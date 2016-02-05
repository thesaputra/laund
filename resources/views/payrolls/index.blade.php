@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Transaksi
      <small>Payroll</small>
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('payroll.payroll.create') !!}" role="button">+ Payroll</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="transactions-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Payroll Date</th>
          <th>Nama Pegawai</th>
          <th>Bagian</th>
          <th>Sallary</th>
          <th>Bonus</th>
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
        ajax: '{!! route('data.payroll') !!}',
        columns: [
            { data: 'rownum', name: 'rownum',searchable: false},
            { data: 'payroll_date', name: 'transaction_payrolls.payroll_date' },
            { data: 'name', name: 'users.name' },
            { data: 'depart', name: 'transaction_payrolls.depart' },
            { data: 'gpk', name: 'transaction_payrolls.gpk' },
            { data: 'bonus', name: 'transaction_payrolls.bonus' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
