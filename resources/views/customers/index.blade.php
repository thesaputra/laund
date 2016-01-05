@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Pelanggan
      <small>membership</small>
    </h2>
    <div class="text-right">
			<div class="form-group">
				<a class="btn btn-primary" href="{!! route('admin.customer.create') !!}" role="button">+ Pelanggan</a>
			</div>
		</div>
    <table class="table table-striped table-bordered table-hover" id="customers-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Nama</th>
          <th>Alamat</th>
          <th>Telp</th>
          <th>Member</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@stop

@push('scripts')
<script>
$(document).ready(function() {
    $('#customers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('data.customer') !!}',
        columns: [
            {data: 'rownum', name: 'rownum',searchable: false},
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },
            { data: 'membership', name: 'membership' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
