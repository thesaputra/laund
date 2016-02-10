<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Transaction;
use App\Models\Package;
use App\Models\Item;
use App\User;
use App\Models\TransactionDetail;
use App\Models\PaymentHistory;
use App\Models\TransactionItem;
use App\Models\TransactionUser;
use App\Models\Customer;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class ReportController extends Controller
{
  public function index()
  {
    $user = User::lists('name', 'id');

    return view('reports.index',compact(['user']));
  }

  public function daily()
  {
    return view('reports.daily');
  }

  public function status()
  {
    return view('reports.status');
  }

  public function process_status(Request $request)
  {
    $date_start = $this->saved_date_format($request->input('date_start'));
    $date_end = $this->saved_date_format($request->input('date_end'));

    $data = $this->get_data_report_status($date_start,$date_end);
    // dd($data);
    // die();
    $date_start = $request->input('date_start');
    $date_end = $request->input('date_end');

    $view =  \View::make('reports.print_daily_status', compact('data','date_start','date_end'))->render();

    return view('reports.print_daily_status', compact('data','date_start','date_end'));

    // $pdf = \App::make('dompdf.wrapper');
    // $pdf->loadHTML($view);
    // return $pdf->stream('invoice');
  }

  public function process(Request $request)
  {
    $date_start = $this->saved_date_format($request->input('date_start'));
    $date_end = $this->saved_date_format($request->input('date_end'));
    $user_id = $request->input('user_id');
    $task = $request->input('tugas');

    $tipe = $request->input('tipe');

    $user_name = User::find($user_id)->name;

    if ($tipe != 'Pcs') {
      $data = $this->get_data_report($date_start,$date_end,$user_id,$task);
      $date_start = $request->input('date_start');
      $date_end = $request->input('date_end');

      // $view =  \View::make('reports.print_sallary_report', compact('data','date_start','date_end','user_name'))->render();
      return view('reports.print_sallary_report', compact('data','date_start','date_end','user_name'));

    } else {
      $data = $this->get_data_report_pcs($date_start,$date_end,$user_id,$task);
      $date_start = $request->input('date_start');
      $date_end = $request->input('date_end');

      // $view =  \View::make('reports.print_sallary_report_pcs', compact('data','date_start','date_end','user_name'))->render();
      return view('reports.print_sallary_report_pcs', compact('data','date_start','date_end','user_name'));

    }


    // $pdf = \App::make('dompdf.wrapper');
    // $pdf->loadHTML($view);
    // return $pdf->stream('invoice');
  }

  public function get_data_report($date_start,$date_end,$user_id,$task)
  {
    // dd($task);
    // die();
    $date_end = Carbon::parse($date_end)->addDays(1);
    $results = Transaction::whereBetween('transaction_users.end_date', [$date_start, $date_end])
    ->join('transaction_users','transaction_users.transaction_id','=','transactions.id')
    ->join('packages','transaction_users.package_id','=','packages.id')
    ->join('status','transactions.status_id','=','status.id')
    ->join('users','transaction_users.user_id','=','users.id')
    ->select('transactions.invoice_number','status.name as status_trans','transactions.date_order','transaction_users.end_date as tgl_pengerjaan',
             'transaction_users.qty','transaction_users.end_date','transaction_users.status',
             'packages.name as package_name','packages.price_opr','packages.price_regular','packages.price_express','packages.unit','users.name as user_name')
    ->whereBetween('transaction_users.end_date', [$date_start, $date_end])
    ->where('transaction_users.status','=','Selesai')
    ->where('packages.unit','!=','Pcs')
    ->where('packages.unit','!=','Mtr')
    ->where('packages.name','LIKE','%'.$task.'%')
    ->where('transactions.deleted','=',0)
    ->where('transaction_users.user_id','=',$user_id)
    ->get();

    return $results;
  }

  public function get_data_report_pcs($date_start,$date_end,$user_id,$task)
  {
    $date_end = Carbon::parse($date_end)->addDays(1);
    $results = Transaction::whereBetween('transaction_pcs.end_date', [$date_start, $date_end])
    ->join('transaction_pcs','transaction_pcs.transaction_id','=','transactions.id')
    ->join('packages','transaction_pcs.package_id','=','packages.id')
    ->join('status','transactions.status_id','=','status.id')
    ->join('users','transaction_pcs.user_id','=','users.id')
    ->select('transactions.invoice_number','status.name as status_trans','transactions.date_order',
             'transaction_pcs.qty','transaction_pcs.end_date','transaction_pcs.status','transaction_pcs.price','transaction_pcs.package_detail','transaction_pcs.end_date as tgl_pengerjaan',
             'packages.name as package_name','packages.price_opr','packages.price_regular','packages.price_express','packages.unit','users.name as user_name')
    ->whereBetween('transaction_pcs.end_date', [$date_start, $date_end])
    ->where('transaction_pcs.status','=','Selesai')
    ->where('transaction_pcs.package_detail','LIKE','%'.$task.'%')
    ->where('transaction_pcs.user_id','=',$user_id)
    ->where('transactions.deleted','=',0)
    ->get();

    return $results;
  }

  public function process_daily(Request $request)
  {
    $date_start = $this->saved_date_format($request->input('date_start'));
    $date_end = $this->saved_date_format($request->input('date_end'));

    $data = $this->get_data_report_daily($date_start,$date_end);
    // dd($data);
    // die();
    $date_start = $request->input('date_start');
    $date_end = $request->input('date_end');

    return view('reports.print_daily_recap', compact('data','date_start','date_end'));


    // $view =  \View::make('reports.print_daily_recap', compact('data','date_start','date_end'))->render();
    // $pdf = \App::make('dompdf.wrapper');
    // $pdf->loadHTML($view);
    // return $pdf->stream('invoice');
  }

  public function get_data_report_status($date_start,$date_end)
  {
    // $date_end = Carbon::parse($date_end)->addDays(1);
    $results = \DB::select(\DB::raw("select transactions.date_order as trans_date_order, transactions.invoice_number as trans_invoice, customers.name as cust_name,customers.address as cust_address,
                               transaction_details.package_type as trans_detail_type, transactions.id as trans_id, transactions.amount_left as trans_amount_total,
                              (SELECT

                             sum(transaction_details.qty)
                                from transaction_details
                                LEFT JOIN packages ON
                                packages.id = transaction_details.package_id
                                where transaction_details.transaction_id = trans_id AND packages.unit = 'Kg'
                              ) as jml_kg,

                              (SELECT

                             sum(transaction_details.qty)
                                from transaction_details
                                LEFT JOIN packages ON
                                packages.id = transaction_details.package_id
                                where  transaction_details.transaction_id = trans_id AND packages.unit = 'Pcs'
                              ) as jml_pcs,


                              (SELECT

                             sum(transaction_details.qty)
                                from transaction_details
                                LEFT JOIN packages ON
                                packages.id = transaction_details.package_id
                                where transaction_details.transaction_id = trans_id AND packages.unit = 'Mtr'
                              ) as jml_mtr,

                              (SELECT

                             sum(payment_histories.amount)
                                from payment_histories
                                LEFT JOIN transactions ON
                                payment_histories.transaction_id = transactions.id
                                where payment_histories.transaction_id = trans_id
                              ) as sudah_bayar

                     FROM transactions
                     LEFT JOIN transaction_details ON
                     transaction_details.transaction_id = transactions.id
                     LEFT JOIN packages ON
                     packages.id = transaction_details.package_id
                     LEFT JOIN customers on transactions.customer_id = customers.id

                     WHERE transactions.date_order BETWEEN '$date_start' AND '$date_end'
                     AND transactions.deleted = 0
                     group by transactions.id
                      "));


    return $results;
  }

  public function get_data_report_daily($date_start,$date_end)
  {
    $date_end = Carbon::parse($date_end)->addDays(1);

    $results = PaymentHistory::whereBetween('payment_histories.payment_date', [$date_start, $date_end])
    ->join('transactions','payment_histories.transaction_id','=','transactions.id')
    ->join('transaction_details','transaction_details.transaction_id','=','transaction_details.id')
    ->join('packages','transaction_details.package_id','=','packages.id')
    ->join('customers','transactions.customer_id','=','customers.id')
    ->join('status','transactions.status_id','=','status.id')

    ->select('transaction_details.qty as jml_kg','packages.unit as unit_satuan','payment_histories.amount as amount_payment','payment_histories.payment_date as date_hist_payment','payment_histories.description as desc_payment','payment_histories.created_at as created_at_payment', 'transactions.invoice_number','transactions.date_checkout','transactions.discount','status.name as status_trans','transactions.date_order',
             'payment_histories.description','customers.name as customer_name','customers.address as customer_address','transaction_details.package_type as tipe_paket','packages.price_regular as harga_regular','packages.price_express as harga_express'


             )
    ->where('transactions.deleted','=',0)
    ->get();

    return $results;
  }



  private function saved_date_format($date)
  {
    $date_split = explode('/',$date);
    $year = $date_split[2];
    $month = $date_split[1];
    $day = $date_split[0];

    $format = $year.'-'.$month.'-'.$day;

    return $format;
  }



}
