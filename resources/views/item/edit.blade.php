@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
    </div>
  <div class="col-md-6">
    <h2 class="page-header">Update Jenis
      <small>pakaian</small>
    </h2>
        {!! Form::model($item,['method' => 'PATCH','route'=>['admin.item.update',$item->id]]) !!}
        <div class="form-group">
            {!! Form::label('Nama', 'Nama:') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
  </div>
</div>
@endsection
