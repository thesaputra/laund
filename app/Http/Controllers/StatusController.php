<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Status;

use Yajra\Datatables\Datatables;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
     {
       return view('status.index');
     }

     public function status_data()
     {
       \DB::statement(\DB::raw('set @rownum=0'));
       $status = Status::select([
         \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
         'id',
         'name'
       ]);
       return Datatables::of($status)
       ->addColumn('action', function ($stat) {
         return '<a href="./status/edit/'.$stat->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
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
        return view('status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $this->validation_rules($request);

      $status=$request->input();
      Status::create($status);

      Session::flash('flash_message', 'Data status layanan berhasil ditambahkan!');

      return redirect('admin/status');
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
      $status=Status::find($id);
      return view('status.edit',compact('status'));
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
      $this->validation_rules($request);

      $statusUpdate=$request->input();

      $status=Status::find($id);
      $status->update($statusUpdate);

      Session::flash('flash_message', 'Data status layanan berhasil diupdate!');

      return redirect('admin/status');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validation_rules($request)
    {
      $this->validate($request, [
          'name' => 'required'
      ]);
    }
}
