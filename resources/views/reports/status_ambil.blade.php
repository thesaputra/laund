@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Laporan
      <small>Pelanggan Sudah Ambil Laundry</small>
    </h2>
    {!! Form::open(['route' => 'admin.report.post_status_ambil']) !!}
    <div class="row">
      <div class="col-md-3">
        <div class="form-group">
          {!! Form::label('date_start', 'Mulai:') !!}
          {!! Form::text('date_start',null,['id'=>'date-start','class'=>'form-control','required'=>'true']) !!}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          {!! Form::label('date_end', 'Akhir:') !!}
          {!! Form::text('date_end',null,['id'=>'date-end','class'=>'form-control','required'=>'true']) !!}
        </div>
      </div>
      <div class="col-md-3">
        <div class="form-group">
          <label>&nbsp;</label>
          {!! Form::submit('Proses', ['class' => 'btn btn-success form-control']) !!}
        </div>
      </div>
    {!! Form::close() !!}
  </div>
  <small>Note: Periode tanggal berdasarkan tanggal order di transaksi</small>
</div>

<script>
$(document).ready(function() {

  $('#date-start').datepicker({
    format: "dd/mm/yyyy",
    language: "id"
  });
  $('#date-end').datepicker({
    format: "dd/mm/yyyy",
    language: "id"
  });

});
</script>
@stop
