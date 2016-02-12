@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Pengeluaran
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('outcome.outcome.create') !!}" role="button">+ Pengeluaran</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="status-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Tanggal</th>
          <th>Nama Toko</th>
          <th>Tlp Toko</th>
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
        ajax: '{!! route('data.outcome') !!}',
        columns: [
            {data: 'rownum', name: 'rownum',searchable: false},
            {data: 'trans_date', name: 'trans_date' },
            {data: 'store_name', name: 'store_name' },
            {data: 'store_tlp', name: 'store_tlp' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
