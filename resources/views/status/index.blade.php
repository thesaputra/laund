@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Status
      <small>Layanan</small>
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('admin.status.create') !!}" role="button">+ Status Layanan</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="status-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Nama</th>
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
        ajax: '{!! route('data.status') !!}',
        columns: [
            {data: 'rownum', name: 'rownum',searchable: false},
            { data: 'name', name: 'name' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
