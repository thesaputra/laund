<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use App\Models\Income;
use App\Models\Outcome;


use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class IncomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
       return view('reports.revenue');
   }

   public function process_report(Request $request)
   {
    $date_start = $this->saved_date_format($request->input('date_start'));
    $date_end = $this->saved_date_format($request->input('date_end'));

    $data = $this->get_data_report($date_start,$date_end);
    $data_out = $this->get_data_report_out($date_start,$date_end);
    

    $date_start = $request->input('date_start');
    $date_end = $request->input('date_end');

    return view('reports.print_revenue', compact('data','data_out','date_start','date_end'));
}

public function get_data_report($date_start,$date_end)
{
    $date_end = Carbon::parse($date_end)->addDays(1);
    $results = Income::whereBetween('incomes.trans_date', [$date_start, $date_end])
    ->select('incomes.trans_date','incomes.description','incomes.price_income')
    ->whereBetween('incomes.trans_date', [$date_start, $date_end])
    ->where('incomes.deleted','=',0)
    ->get();

    return $results;
}

public function get_data_report_out($date_start,$date_end)
{
    $date_end = Carbon::parse($date_end)->addDays(1);
    $results = Outcome::whereBetween('outcomes.trans_date', [$date_start, $date_end])
    ->select('outcomes.trans_date','outcomes.store_name','outcomes.type_trans','outcomes.store_tlp','outcomes.qty','outcomes.description','outcomes.price_income')
    ->whereBetween('outcomes.trans_date', [$date_start, $date_end])
    ->where('outcomes.deleted','=',0)
    ->get();

    return $results;
}

public function index()
{
 return view('incomes.index');
}

public function income_data()
{
    \DB::statement(\DB::raw('set @rownum=0'));
    $income = \DB::table('incomes')
    ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'),
      'incomes.id',
      'incomes.trans_date',
      'incomes.description',
      'incomes.price_income'
      ])
    ->where('incomes.deleted','=','0')
    ->orderBy('incomes.trans_date', 'desc');

    return Datatables::of($income)
    ->editColumn('trans_date', function ($income) {
        return $income->trans_date ? with(new Carbon($income->trans_date))->format('d/m/Y') : '';
    })
    ->addColumn('action', function ($income) {
      return
      '<div class="col-md-3">
      <a href="./income/edit/'.$income->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
  </div>
  <div class="col-md-3">
    <form method="POST" action="./income/destroy/'.$income->id.'" accept-charset="UTF-8" class="inline">
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('incomes.create');
   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $trans_date = $this->saved_date_format($request->input('trans_date'));
        
        $request->merge(array('trans_date'=>$trans_date));

        $transaction=$request->input();
        $save_trans = Income::create($transaction);

        Session::flash('flash_message', 'Data pemasukan berhasil ditambahkan');

        return redirect()->route('income.income');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income=Income::find($id);

        return view('incomes.edit',compact(['income']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $trans_date = $this->saved_date_format($request->input('trans_date'));
        
        $request->merge(array('trans_date'=>$trans_date));

        $transUpdate=$request->input();
        $trans=Income::find($id);

        $trans->update($transUpdate);

        Session::flash('flash_message', 'Data berhasil diubah!');

        return redirect()->route('income.income');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $transUser=$request->input();

        $trans = Income::find($id);

        $trans->update($transUser);

        Session::flash('flash_message', 'Data berhasil dihapus!');

        return redirect()->back();
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
