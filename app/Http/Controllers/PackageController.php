<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Package;

use Yajra\Datatables\Datatables;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $packages=Package::paginate(10);
      // return view('packages.index',compact('packages'));
      return view('packages.index');
    }

    public function package_data()
    {
      \DB::statement(\DB::raw('set @rownum=0'));
      $packages = Package::select([
        \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
        'id',
        'name',
        'price_regular',
        'price_express',
        'unit',
        'description'
      ]);
      return Datatables::of($packages)
      ->editColumn('price_regular', function ($package) {
                  return number_format($package->price_regular, 2,',', '.');
              })
      ->editColumn('price_express', function ($package) {
                  return number_format($package->price_express, 2,',', '.');
              })
      ->addColumn('action', function ($package) {
        return '<a href="./package/edit/'.$package->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
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
         return view('packages.create');
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

      $package=$request->input();
      Package::create($package);

      Session::flash('flash_message', 'Data paket layanan berhasil ditambahkan!');

      return redirect('admin/package');
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
      $package=Package::find($id);
      return view('packages.edit',compact('package'));
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

      $packageUpdate=$request->input();
      $package=Package::find($id);
      $package->update($packageUpdate);

      Session::flash('flash_message', 'Data Paket layanan berhasil diupdate!');

      return redirect('admin/package');
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
          'name' => 'required',
          'price_regular' => 'required',
          'unit' => 'required'
      ]);
    }
}
