@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <h2 class="page-header">Tambah Pemasukan
      </h2>
      {!! Form::open(['route' => 'income.income.store']) !!}
      <div class="form-group">
        {!! Form::label('trans_date', 'Tanggal Pemasukan:') !!}
        {!! Form::text('trans_date',null,['class'=>'form-control','id'=>'trans-date']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('description', 'Nama Pemasukan:') !!}
        {!! Form::text('description',null,['class'=>'form-control']) !!}
    </div>
    <div class="form-row">
      <label for="c2">Jumlah</label>
      <div class="input-group"> 
        <span class="input-group-addon">Rp</span>
        <input type="number" name="price_income" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="c2" />
        </div>
    </div>
    <br/>
<div class="form-group">
    {!! Form::submit('Save', ['class' => 'btn btn-primary form-control']) !!}
</div>
{!! Form::close() !!}
</div>
</div>

<script>
  $(document).ready(function() {
    $('#trans-date').datepicker({
      format: "dd/mm/yyyy",
      language: "id"
    });

  });
</script>
@endsection
