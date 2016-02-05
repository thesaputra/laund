@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-6">
        <h2 class="page-header">Edit Pemasukan
      </h2>

  {!! Form::model($income,['method' => 'PATCH','route'=>['income.income.update',$income->id]]) !!}
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
        <input type="number" name="price_income" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="c2" value='<?= $income->price_income; ?>' />
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

    date_deliver = '{{ $income->trans_date}}'
    split_deliver = date_deliver.split('-');
    date = split_deliver[2];
    month = split_deliver[1];
    year = split_deliver[0];
    $('#trans-date').val(date+'/'+month+'/'+year);

    $('#trans-date').datepicker({
      format: "dd/mm/yyyy",
      language: "id"
    });

  });
</script>
@endsection
