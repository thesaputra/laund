@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Pemasukan
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('income.income.create') !!}" role="button">+ Pemasukan</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="status-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Tanggal</th>
          <th>Nama</th>
          <th>Jumlah</th>
          <th>Action</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@stop

@push('scripts')
<script>
$(document).ready(function() {
    $('#status-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('data.income') !!}',
        columns: [
            {data: 'rownum', name: 'rownum',searchable: false},
            {data: 'trans_date', name: 'trans_date' },
            {data: 'description', name: 'description' },
            {data: 'price_income', name: 'price_income' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
