<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


use Session;
use App\Models\Outcome;


use Yajra\Datatables\Datatables;

use Carbon\Carbon;

class OutcomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
     {
       return view('outcomes.index');
     }

     public function outcome_data()
     {
        \DB::statement(\DB::raw('set @rownum=0'));
        $outcome = \DB::table('outcomes')
        ->select([\DB::raw('@rownum  := @rownum  + 1 AS rownum'),
          'outcomes.id',
          'outcomes.trans_date',
          'outcomes.store_name',
          'outcomes.type_trans',
          'outcomes.description',
          'outcomes.qty',
          'outcomes.price_income'
          ])
        ->where('outcomes.deleted','=','0')
        ->orderBy('outcomes.trans_date', 'desc');

        return Datatables::of($outcome)
        ->editColumn('trans_date', function ($outcome) {
                    return $outcome->trans_date ? with(new Carbon($outcome->trans_date))->format('d/m/Y') : '';
                })
        ->addColumn('action', function ($outcome) {
          return
            '<div class="col-md-3">
            <a href="./outcome/edit/'.$outcome->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>
            </div>
            <div class="col-md-3">
            <form method="POST" action="./outcome/destroy/'.$outcome->id.'" accept-charset="UTF-8" class="inline">
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
         return view('outcomes.create');
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
        $save_trans = Outcome::create($transaction);

        Session::flash('flash_message', 'Data pengeluaran berhasil ditambahkan');

        return redirect()->route('outcome.outcome');
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
         $outcome=Outcome::find($id);
       
        return view('outcomes.edit',compact(['outcome']));
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
        $trans=Outcome::find($id);

        $trans->update($transUpdate);

        Session::flash('flash_message', 'Data berhasil diubah!');

        return redirect()->route('outcome.outcome');
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

        $trans = Outcome::find($id);

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
