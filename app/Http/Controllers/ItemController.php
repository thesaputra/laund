<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Models\Item;

use Yajra\Datatables\Datatables;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('item.index');
  }

  public function item_data()
  {
    \DB::statement(\DB::raw('set @rownum=0'));
    $items = Item::select([
      \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
      'id',
      'name'
    ]);
    return Datatables::of($items)
    ->addColumn('action', function ($item) {
      return '<a href="./item/edit/'.$item->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
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
      return view('item.create');
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

    $item=$request->input();
    Item::create($item);

    Session::flash('flash_message', 'Data item layanan berhasil ditambahkan!');

    return redirect('admin/item');
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
    $item=Item::find($id);
    return view('item.edit',compact('item'));
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

    $itemUpdate=$request->input();

    $item=Item::find($id);
    $item->update($itemUpdate);

    Session::flash('flash_message', 'Data item layanan berhasil diupdate!');

    return redirect('admin/item');
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
