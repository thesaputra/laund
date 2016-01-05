@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
    </div>
  <div class="col-md-6">
    <h2 class="page-header">Update Pelanggan
      <small>membership</small>
    </h2>
        {!! Form::model($customer,['method' => 'PATCH','route'=>['admin.customer.update',$customer->id]]) !!}
        <div class="form-group">
            {!! Form::label('Nama', 'Nama:') !!}
            {!! Form::text('name',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Alamat', 'Alamat:') !!}
            {!! Form::text('address',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Telp', 'Telp:') !!}
            {!! Form::text('phone',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Code', 'Member ID:') !!}
            {!! Form::text('code',null,['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('membership', 'Membership:') !!}
          {!! Form::select('membership', [
  				'No' => 'No',
  				'Yes' => 'Yes'], null, ['class'=>'form-control']
  				) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Update', ['class' => 'btn btn-primary form-control']) !!}
        </div>
        {!! Form::close() !!}
  </div>
</div>
@endsection
