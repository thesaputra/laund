@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
    </div>
  <div class="col-md-6">
    <h2 class="page-header">Update Paket
      <small>layanan</small>
    </h2>
        {!! Form::model($package,['method' => 'PATCH','route'=>['admin.package.update',$package->id]]) !!}
        <div class="form-group">
            {!! Form::label('Nama', 'Nama:') !!}
            {!! Form::text('name',null,['class'=>'form-control','required'=>'true']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Price Regular', 'Price Regular:') !!}
            {!! Form::text('price_regular',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Price Express', 'Price Express:') !!}
            {!! Form::text('price_express',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Price Operational', 'Price Operational:') !!}
            {!! Form::text('price_opr',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('unit', 'Satuan:') !!}
            {!! Form::select('unit', [
    				'Kg' => 'Kg',
    				'Mtr' => 'Mtr',
            'Pcs' => 'Pcs'],
             null, ['class'=>'form-control']
    				) !!}
        </div>
        <div class="form-group">
            {!! Form::label('description', 'Keterangan:') !!}
            {!! Form::textarea('description',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
  </div>
</div>
@endsection
