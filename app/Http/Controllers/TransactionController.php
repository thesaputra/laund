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
use App\Models\TransactionPcs;
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
      'customers.address as cust_address',
      'customers.phone as cust_phone',
      'transactions.deleted as delete_trans'
      ])
    ->where('transactions.deleted','=','0')
    ->orderBy('transactions.date_order', 'desc');

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
      return
        '<div class="col-md-3">
        <a href="./transaction/edit/'.$transaction->trans_id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
        </div>
        <div class="col-md-6">
        <a href="./transaction/detail/'.$transaction->trans_id.'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-globe"></i> Detail</a>
        </div>
        <div class="col-md-3">
        <form method="POST" action="./transaction/delete_transaction/'.$transaction->trans_id.'" accept-charset="UTF-8" class="inline">
          <input name="_method" type="hidden" value="PATCH">
          <input name="_token" type="hidden" value="'.csrf_token().'">
          <input id="deleted" class="form-control" name="deleted" type="hidden" value="1">
          <input class="inline btn btn-danger btn-xs" type="submit" value="Hapus">
        </form>
        </div>

        ';
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

    $qty = $request->input('qty');
    $harga = $request->input('harga');
    $transaction_id = $request->input('transaction_id');


    $trans=Transaction::find($transaction_id);
    $trans->update(array('amount_left'=>(($qty*$harga)+$trans->amount_left)));

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

    // return redirect()->route('kasir.transaction.detail_user', $request->input('transaction_id'));
      return Redirect::to(URL::previous() . "#tab1default");
  }

  public function store_pcs(Request $request)
  {
    $this->validation_user_rules($request);
    $start_date = $this->saved_date_time_format($request->input('start_date'));
    $end_date = $this->saved_date_time_format($request->input('end_date'));

    $pack_type = $request->input('package_type');
    $qty = $request->input('qty');
    $price_reg = $request->input('price_reg');
    $price_exp =  $request->input('price_exp');
    $pack_detail = $request->input('package_detail');

    $price = 0;
    if ($pack_type == 1) {
      if ($pack_detail == 'Tag') {
        $price = ((0.01 * $price_reg) * $qty);
      } elseif ($pack_detail == 'Cuci') {
        $price = ((0.05 * $price_reg) * $qty);
      } elseif ($pack_detail == 'Setrika') {
        $price = ((0.05 * $price_reg) * $qty);
      } elseif ($pack_detail == 'Qc') {
        $price = ((0.02 * $price_reg) * $qty);
      } elseif ($pack_detail == 'Packing') {
        $price = ((0.02 * $price_reg) * $qty);
      }
    } else {
      if ($pack_detail == 'Tag') {
        $price = ((0.01 * $price_exp) * $qty);
      } elseif ($pack_detail == 'Cuci') {
        $price = ((0.05 * $price_exp) * $qty);
      } elseif ($pack_detail == 'Setrika') {
        $price = ((0.05 * $price_exp) * $qty);
      } elseif ($pack_detail == 'Qc') {
        $price = ((0.02 * $price_exp) * $qty);
      } elseif ($pack_detail == 'Packing') {
        $price = ((0.02 * $price_exp) * $qty);
      }
    }

    $request->merge(array('start_date' => $start_date,'end_date'=>$end_date,'price'=>$price));

    $trans_user=$request->input();
    $save_trans_user = TransactionPcs::create($trans_user);

    // return redirect()->route('kasir.transaction.detail_user', $request->input('transaction_id'));
    return Redirect::to(URL::previous() . "#tab2default");
  }

  public function store_payment(Request $request)
  {
    $payment_date = $this->saved_date_format($request->input('payment_date'));

    $request->merge(array('payment_date' => $payment_date));

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

    $list_detail = TransactionDetail::where('transaction_details.transaction_id','=', $id)
    ->join('packages','transaction_details.package_id','=','packages.id')
    ->select('transaction_details.*','transaction_details.id as detail_id','packages.*')
    ->paginate(50);

    // dd($list_detail);
    // die();
    $total_qtys = 0;
    $type_paket = '';
    foreach ($list_detail as $value) {
       $total_qtys += $value['qty'];
       $type_paket = $value['package_type'];
    }

    $list_item = TransactionItem::where('transaction_items.transaction_id','=', $id)
    ->join('items','transaction_items.item_id','=','items.id')
    ->select('transaction_items.*','transaction_items.id as trans_item_id','items.*')
    ->paginate(25);

    $data_transaction = array(
      'transaction'  => $transaction,
      'detail_transaction'   => $list_detail,
      'item_transaction' => $list_item,
      'total_qtys' => $total_qtys,
      'type_paket' => $type_paket
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

    $list_pcs = TransactionPcs::where('transaction_pcs.transaction_id','=', $id)
    ->join('users','transaction_pcs.user_id','=','users.id')
    ->join('packages','transaction_pcs.package_id','=','packages.id')
    ->select('transaction_pcs.*','transaction_pcs.id as trans_user_id','users.*','packages.name as package_name')
    ->paginate(25);

    $list_detail = TransactionDetail::where('transaction_details.transaction_id','=', $id)
    ->join('packages','transaction_details.package_id','=','packages.id')
    ->select('transaction_details.*','transaction_details.id as detail_id','packages.*')
    ->paginate(25);


    $data_transaction = array(
      'transaction'  => $transaction,
      'user_transaction' => $list_user,
      'detail_transaction'   => $list_detail,
      'pcs_transaction' => $list_pcs

    );

    return view('transactions.detail_user',compact('data_transaction'));
  }

  public function user_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('users')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(25)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name,'address' => $query->address,'phone' => $query->phone ];
    }

    return response()->json($results);
  }

  public function item_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('items')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(25)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name ];
    }

    return response()->json($results);
  }

  public function package_autocomplete_trans(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('packages')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->take(25)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name, 'price_regular' => $query->price_regular, 'price_express' => $query->price_express, 'unit' => $query->unit ];
    }

    return response()->json($results);
  }

  public function package_autocomplete(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('packages')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->where('unit','!=','Pcs')
    ->take(25)->get();

    foreach ($queries as $query)
    {
      $results[] = [ 'id' => $query->id, 'name' => $query->name, 'price_regular' => $query->price_regular, 'price_express' => $query->price_express, 'unit' => $query->unit ];
    }

    return response()->json($results);
  }

  public function package_autocomplete_pcs(Request $request)
  {
    $term = $request->term;

    $results = array();

    $queries = \DB::table('packages')
    ->where('name', 'LIKE', '%'.$term.'%')
    ->where('unit','!=','Kg')
    ->take(25)->get();

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
    ->where('deleted', '=', 0)
    ->orWhere('phone', 'LIKE', '%'.$term.'%')
    ->take(25)->get();

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

    Session::flash('flash_message', 'Data berhasil diubah!');

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

    Session::flash('flash_message', 'Status berhasil diubah');

    return Redirect::to(URL::previous() . "#tab1default");
  }

  public function update_status_pcs(Request $request, $id)
  {
    if ($request->input('status') == 'Proses'){
      $request->merge(array('status'=>'Selesai'));
    } else {
      $request->merge(array('status'=>'Proses'));
    }

    $transUser=$request->input();

    $trans = TransactionPcs::findOrFail($id);

    $trans->update($transUser);

    Session::flash('flash_message', 'Status berhasil diubah');

    return Redirect::to(URL::previous() . "#tab2default");

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


      $trans_id = $transDetail->transaction_id;
      $trans_pack_type = $transDetail->package_type;
      $trans_pack_qty = $transDetail->qty;
      $trans_pack_id = $transDetail->package_id;

      $pack = Package::find($trans_pack_id);
      $hasil = 0;

      if ($trans_pack_type == 1) {
        $price = $pack->price_regular;
        $hasil = $price * $trans_pack_qty;
      }
      else
      {
        $price = $pack->price_express;
        $hasil = $price * $trans_pack_qty;
      }

      $trans=Transaction::find($trans_id);
      $trans->update(array('amount_left'=>($trans->amount_left - $hasil)));

      $transDetail->delete();
      Session::flash('flash_message', 'Data berhasil dihapus');

      return Redirect::to(URL::previous() . "#detail-item");
  }

  public function destroy_detail_user($id)
  {
      $transDetail = TransactionUser::findOrFail($id);

      $transDetail->delete();

      Session::flash('flash_message', 'Data berhasil dihapus');

      return Redirect::to(URL::previous() . "#tab1default");
  }

  public function destroy_detail_user_pcs($id)
  {
      $transDetail = TransactionPcs::findOrFail($id);

      $transDetail->delete();

      Session::flash('flash_message', 'Data berhasil dihapus');

    return Redirect::to(URL::previous() . "#tab2default");
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


    $list_detail = TransactionDetail::where('transaction_details.transaction_id','=', $id)
    ->join('packages','transaction_details.package_id','=','packages.id')
    ->select('transaction_details.*','transaction_details.id as detail_id','packages.*')
    ->paginate(50);

    // dd($list_detail);
    // die();
    $total_qtys = 0;
    $type_paket = '';
    foreach ($list_detail as $value) {
       $total_qtys += $value['qty'];
       $type_paket = $value['package_type'];
    }

    $date = $data['transaction']['date_order'];
    $invoice = $data['transaction']['invoice_number'];
    $view =  \View::make('transactions.print_items', compact('data', 'date', 'invoice','total_qtys','type_paket'))->render();
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

  public function delete_transaction(Request $request, $id)
  {
    $transUser=$request->input();

    $trans = Transaction::find($id);

    $trans->update($transUser);

    Session::flash('flash_message', 'Data Transaksi berhasil dihapus!');

    return redirect()->back();
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
