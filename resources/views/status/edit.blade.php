@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
    </div>
  <div class="col-md-6">
    <h2 class="page-header">Update Status
      <small>layanan</small>
    </h2>
        {!! Form::model($status,['method' => 'PATCH','route'=>['admin.status.update',$status->id]]) !!}
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
