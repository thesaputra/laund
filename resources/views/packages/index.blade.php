@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Paket
      <small>Layanan</small>
    </h2>
    <div class="text-right">
			<div class="form-group">
				<a class="btn btn-primary" href="{!! route('admin.package.create') !!}" role="button">+ Paket</a>
			</div>
		</div>
    <table class="table table-striped table-bordered table-hover" id="packages-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Jenis Layanan</th>
          <th>Price Regular</th>
          <th>Price Express</th>
          <th>Satuan</th>
          <th>Keterangan</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
@stop

@push('scripts')
<script>
$(document).ready(function() {
    $('#packages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('data.package') !!}',
        columns: [
            { data: 'rownum', name: 'rownum',searchable: false},
            { data: 'name', name: 'name' },
            { data: 'price_regular', name: 'price_regular'},
            { data: 'price_express', name: 'price_express'},
            { data: 'unit', name: 'unit' },
            { data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endpush
