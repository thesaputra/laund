<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Transaction;
use App\Models\Package;
use App\Models\Item;
use App\User;
use App\Models\TransactionDetail;
use App\Models\TransactionItem;
use App\Models\TransactionUser;
use App\Models\PaymentHistory;
use App\Models\Customer;
use App\Models\Status;

use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class TransactionController extends Controller
{
  public function index()
  {
    return view('transactions.index');
  }
  public function transaction_data()
  {
    \DB::statement(\DB::raw('set @rownum=0'));
    $transactions = \DB::table('transactions')
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->join('status', 'transactions.status_id', '=', 'status.id')
    ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'),
      'status.name as status_name',
      'status.id as status_id',
      'transactions.id as trans_id',
      'transactions.invoice_number as invoice_number',
      'transactions.date_order as date_order',
      'transactions.date_deliver as date_deliver',
      'transactions.time_deliver as time_deliver',
      'transactions.rack_info',
      'customers.name as cust_name',
      'customers.phone as cust_phone'
      ])
    ->orderBy('transactions.date_deliver', 'desc');

    return Datatables::of($transactions)
    ->editColumn('cust_name', function ($transaction) {
                return $transaction->cust_name.'-'.$transaction->cust_phone;
            })
    ->editColumn('status_name', function ($transaction) {
                return $transaction->status_name.'/'.$transaction->rack_info;
            })
    ->editColumn('date_order', function ($transaction) {
                return $transaction->date_order ? with(new Carbon($transaction->date_order))->format('d/m/Y') : '';
            })
    ->editColumn('date_deliver', function ($transaction) {
                return $transaction->date_deliver ? with(new Carbon($transaction->date_deliver))->format('d/m/Y').'-'.$transaction->time_deliver : '';
            })
    ->addColumn('action', function ($transaction) {
      return '<a href="./transaction/edit/'.$transaction->trans_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a> <a href="./transaction/detail/'.$transaction->trans_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-globe"></i> Detail</a>';
    })
    ->make(true);
  }

  public function create()
  {
    return view('transactions.create');
  }

  public function store(Request $request)
  {
    $this->validation_rules($request);

    $date_order = $this->saved_date_format($request->input('date_order'));
    $date_deliver = $this->saved_date_format($request->input('date_deliver'));
    $invoice_number = $this->invoiced($request->input('date_deliver'));

    $request->merge(array('status_id'=>1, 'invoice_number' => $request->input('customer_id').'-'.$invoice_number,'date_order'=>$date_order,'date_deliver'=>$date_deliver));

    $transaction=$request->input();
    $save_trans = Transaction::create($transaction);

    $LastInsertId = $save_trans->id;

    Session::flash('flash_message', 'Data transaksi berhasil ditambahkan, silahkan isi detail transaksi berikut');

    return redirect()->route('kasir.transaction.detail', $LastInsertId);

  }

  public function store_detail(Request $request)
  {
    $this->validation_detail_rules($request);

    $trans_detail=$request->input();
    $save_trans_detail = TransactionDetail::create($trans_detail);

    return Redirect::to(URL::previous() . "#detail-item");
  }

  public function store_item(Request $request)
  {
    $this->validation_item_rules($request);

    $trans_item=$request->input();
    $save_trans_item = TransactionItem::create($trans_item);

    return redirect()->route('kasir.transaction.detail_item', $request->input('transaction_id'));
  }

  public function store_user(Request $request)
  {
    $this->validation_user_rules($request);
    $start_date = $this->saved_date_time_format($request->input('start_date'));
    $end_date = $this->saved_date_time_format($request->input('end_date'));

    $request->merge(array('start_date' => $start_date,'end_date'=>$end_date));

    $trans_user=$request->input();
    $save_trans_user = TransactionUser::create($trans_user);

    return redirect()->route('kasir.transaction.detail_user', $request->input('transaction_id'));
  }

  public function store_payment(Request $request)
  {
    $payment=$request->input();
    $save_payment = PaymentHistory::create($payment);

    return Redirect::to(URL::previous() . "#history-payment");
  }

  public function detail($id)
  {
    $transaction = Transaction::where('transactions.id', '=', $id)
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->join('users', 'transactions.user_id', '=', 'users.id')
    ->select('transactions.*', 'customers.name', 'customers.address', 'customers.phone','customers.membership','users.name as username')
    ->firstOrFail();

    $list_detail = TransactionDetail::where('transaction_details.transaction_id','=', $id)
    ->join('packages','transaction_details.package_id','=','packages.id')
    ->select('transaction_details.*','transaction_details.id as detail_id','packages.*')
    ->paginate(25);

    $payment_histories = PaymentHistory::where('payment_histories.transaction_id','=', $id)
    ->select('payment_histories.*')
    ->paginate(25);


    $data_transaction = array(
      'transaction'  => $transaction,
      'detail_transaction'   => $list_detail,
      'payment_histories' => $payment_histories
    );

    return view('transactions.detail',compact('data_transaction'));
  }

  public function detail_item($id)
  {
    $transaction = Transaction::where('transactions.id', '=', $id)
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->join('users', 'transactions.user_id', '=', 'users.id')
    ->select('transactions.*', 'customers.name', 'customers.address', 'customers.phone','customers.membership','users.name as username')
    ->firstOrFail();

    $list_item = TransactionItem::where('transaction_items.transaction_id','=', $id)
    ->join('items','transaction_items.item_id','=','items.id')
    ->select('transaction_items.*','transaction_items.id as trans_item_id','items.*')
    ->paginate(25);

    $data_transaction = array(
      'transaction'  => $transaction,
      'item_transaction' => $list_item
    );

    return view('transactions.detail_item',compact('data_transaction'));
  }

  public function detail_user($id)
  {
    $transaction = Transaction::where('transactions.id', '=', $id)
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->join('users', 'transactions.user_id', '=', 'users.id')
    ->select('transactions.*', 'customers.name', 'customers.address', 'customers.phone','customers.membership','users.name as username')
    ->firstOrFail();

    $list_user = TransactionUser::where('transaction_users.transaction_id','=', $id)
    ->join('users','transaction_users.user_id','=','users.id')
    ->join('packages','transaction_users.package_id','=','packages.id')
    ->select('transaction_users.*','transaction_users.id as trans_user_id','users.*','packages.name as package_name')
    ->paginate(25);


    $data_transaction = array(
      'transaction'  => $transaction,
      'user_transaction' => $list_user
    );

    return view('transactions.detail_user',compact('data_transaction'));
  }

  public function user_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('users')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(10)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name ];
    }

    return response()->json($results);
  }

  public function item_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('items')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(10)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name ];
    }

    return response()->json($results);
  }

  public function package_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('packages')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(10)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name, 'price_regular' => $query->price_regular, 'price_express' => $query->price_express, 'unit' => $query->unit ];
    }

    return response()->json($results);
  }

  public function customer_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('customers')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->orWhere('phone', 'LIKE', '%'.$term.'%')
    ->take(10)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name.' - '.$query->address, 'phone' => $query->phone, 'address' => $query->address ];
    }

    return response()->json($results);
  }


  public function edit($id)
  {
    $transaction=Transaction::find($id);
    $customer = Customer::where('id', '=', $transaction->customer_id)->firstOrFail();
    $status = Status::lists('name', 'id');

    return view('transactions.edit',compact(['transaction','customer','status']));
  }


  public function update(Request $request, $id)
  {

    if ($request->input('date_order') != null) {
      $date_order = $this->saved_date_format($request->input('date_order'));
      $date_deliver = $this->saved_date_format($request->input('date_deliver'));
      if ($request->input('date_checkout') != null) {
        $date_checkout = $this->saved_date_format($request->input('date_checkout'));
      } else {
        $date_checkout = "0000-00-00";
      }
      $request->merge(array($request->input('customer_id'),'date_order'=>$date_order,'date_deliver'=>$date_deliver,'date_checkout'=>$date_checkout));
    }

    $transUpdate=$request->input();
    $trans=Transaction::find($id);

    $trans->update($transUpdate);

    Session::flash('flash_message', 'OK!');

    return redirect()->back();
  }


  public function update_status(Request $request, $id)
  {
    if ($request->input('status') == 'Proses'){
      $request->merge(array('status'=>'Selesai'));
    } else {
      $request->merge(array('status'=>'Proses'));
    }

    $transUser=$request->input();

    $trans = TransactionUser::findOrFail($id);

    $trans->update($transUser);

    Session::flash('flash_message', 'OK');

      return redirect()->back();
  }

  public function destroy_history_payment($id)
  {
      $transDetail = PaymentHistory::findOrFail($id);

      $transDetail->delete();

      Session::flash('flash_message', 'Data berhasil dihapus');

      return Redirect::to(URL::previous() . "#history-payment");
  }

  public function destroy_detail($id)
  {
      $transDetail = TransactionDetail::findOrFail($id);

      $transDetail->delete();

      Session::flash('flash_message', 'Data berhasil dihapus');

      return Redirect::to(URL::previous() . "#detail-item");
  }

  public function destroy_detail_user($id)
  {
      $transDetail = TransactionUser::findOrFail($id);

      $transDetail->delete();

      Session::flash('flash_message', 'Data berhasil dihapus');

        return redirect()->back();
  }

  public function destroy_detail_item($id)
  {
      $transDetail = TransactionItem::findOrFail($id);

      $transDetail->delete();

      Session::flash('flash_message', 'Data berhasil dihapus');

      return redirect()->back();
  }

  public function print_item($id)
  {
    $data = $this->get_data_detail_item($id);

    $date = $data['transaction']['date_order'];
    $invoice = $data['transaction']['invoice_number'];
    $view =  \View::make('transactions.print_items', compact('data', 'date', 'invoice'))->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
  }

  public function get_data_detail_item($id)
  {
    $transaction = Transaction::where('transactions.id', '=', $id)
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->join('users', 'transactions.user_id', '=', 'users.id')
    ->select('transactions.*', 'customers.name', 'customers.address', 'customers.phone','customers.membership','users.name as username')
    ->firstOrFail();

    $list_item = TransactionItem::where('transaction_items.transaction_id','=', $id)
    ->join('items','transaction_items.item_id','=','items.id')
    ->select('transaction_items.*','transaction_items.id as trans_item_id','items.name as item_name')
    ->get();


    $data = array(
      'transaction'  => $transaction,
      'item_transaction' => $list_item
    );

    return $data;
  }

  public function print_invoice($id)
  {
    $data = $this->get_data_detail($id);
    // dd($data);
    // die();
    $sum_amount = PaymentHistory::where('payment_histories.transaction_id','=', $id)->sum('amount');


    $date = $data['transaction']['date_order'];
    $invoice = $data['transaction']['invoice_number'];
    $view =  \View::make('transactions.print_invoice', compact('data', 'date', 'invoice', 'sum_amount'))->render();
    $pdf = \App::make('dompdf.wrapper');
    $pdf->loadHTML($view);
    return $pdf->stream('invoice');
  }

  public function get_data_detail($id)
  {
    $transaction = Transaction::where('transactions.id', '=', $id)
    ->join('customers', 'transactions.customer_id', '=', 'customers.id')
    ->join('users', 'transactions.user_id', '=', 'users.id')
    ->select('transactions.*', 'customers.name', 'customers.address', 'customers.phone','customers.membership','users.name as username')
    ->firstOrFail();

    $list_detail = TransactionDetail::where('transaction_details.transaction_id','=', $id)
    ->join('packages','transaction_details.package_id','=','packages.id')
    ->select('transaction_details.*','transaction_details.id as detail_id','packages.*')
    ->paginate(25);

    $data =  [
        'transaction'          => $transaction,
        'detail_transaction'   => $list_detail
    ];

    return $data;
  }

  private function invoiced($date)
  {
    $date = explode('/',$date);

    $year = $date[2];
    $month = $date[1];
    $day = $date[0];

    $timenow = Carbon::now()->toDateTimeString();

    $format = substr($year, -2).''.$month.''.$day.Carbon::parse($timenow)->format('i');

    return $format;
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

  private function saved_date_time_format($date)
  {
    $date_split = explode('/',$date);

    $year = explode(' ',$date_split[2]);
    $month = $date_split[1];
    $day = $date_split[0];

    $format = $year[0].'-'.$month.'-'.$day.' '.$year[1];

    return $format;
  }

  private function validation_rules($request)
  {
    $this->validate($request, [
      'date_order' => 'required'
    ]);
  }

  private function validation_detail_rules($request)
  {
    $this->validate($request, [
      'package_id' => 'required'
    ]);
  }

  private function validation_item_rules($request)
  {
    $this->validate($request, [
      'item_id' => 'required'
    ]);
  }

  private function validation_user_rules($request)
  {
    $this->validate($request, [
      'user_id' => 'required'
    ]);
  }
}
