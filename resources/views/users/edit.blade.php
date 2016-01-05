@extends('layouts.app')

@section('content')
<div class="row">
  {!! Form::model($user,['method' => 'PATCH','route'=>['admin.user.update',$user->id]]) !!}
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
  <h2 class="page-header">Edit Data Pegawai
  </h2>
  <div class="col-md-6">
    <div class="form-group">
      {!! Form::label('name', 'Username:') !!}
      {!! Form::text('name',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('email', 'Email:') !!}
      {!! Form::text('email',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('password', 'Password:') !!}
      <input type="password" class="form-control" name="password">
    </div>
    <div class="form-group">
      {!! Form::label('password_confirmation', 'Password Konfirmasi:') !!}
      <input type="password" class="form-control" name="password_confirmation">
    </div>
    <div class="form-group">
      {!! Form::label('address', 'Alamat:') !!}
      {!! Form::text('address',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
      {!! Form::label('phone', 'Telepon:') !!}
      {!! Form::text('phone',null,['class'=>'form-control']) !!}
    </div>
  {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
  </div>
  {!! Form::close() !!}
</div>
@endsection
