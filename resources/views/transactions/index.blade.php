@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Transaksi
      <small>Invoices</small>
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('kasir.transaction.create') !!}" role="button">+ Transaksi</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="transactions-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Invoice Number</th>
          <th>Tanggal Order</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Tgl & Waktu Selesai</th>
          <th>Status/R.Info</th>
          <th>Action</th>
        </tr>
      </thead>

    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#transactions-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('data.transaction') !!}',
        columns: [
            { data: 'rownum', name: 'rownum',searchable: false},
            { data: 'invoice_number', name: 'transactions.invoice_number' },
            { data: 'date_order', name: 'transactions.date_order' },
            { data: 'cust_name', name: 'customers.name' },
            { data: 'cust_address', name: 'customers.address' },
            { data: 'date_deliver', name: 'transactions.date_deliver' },
            { data: 'status_name', name: 'status.name' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
