@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Jenis
      <small>Pakaian</small>
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('admin.item.create') !!}" role="button">+ Jenis Pakaian</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="items-table">
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
    $('#items-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('data.item') !!}',
        columns: [
            {data: 'rownum', name: 'rownum',searchable: false},
            { data: 'name', name: 'name' },
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@endpush
