@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h2 class="page-header">Data Pegawai
      <small>list</small>
    </h2>
    <div class="text-right">
      <div class="form-group">
        <a class="btn btn-primary" href="{!! route('admin.user.create') !!}" role="button">+ Data Pegawai</a>
      </div>
    </div>
    <table class="table table-striped table-bordered table-hover" id="users-table">
      <thead>
        <tr class="bg-info">
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Alamat</th>
          <th>Telepon</th>
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
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('admin.get_user') !!}',
        columns: [
            { data: 'rownum', name: 'rownum',searchable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'address', name: 'address' },
            { data: 'phone', name: 'phone' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

<script>
$(document).ready(function() {
  $('#users-table').on('click', '#btn-delete[data-remote]', function (e) {
    e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': '{!! csrf_token() !!}'
        }
      });
      var url = $(this).data('remote');
      if (confirm('Anda yakin?')) {
        $.ajax({
          url: url,
          type: 'DELETE',
          dataType: 'json',
          data: {method: '_DELETE', submit: true}
        }).always(function (data) {
          $('#users-table').DataTable().draw(false);
        });
      }
    });
});
</script>
@endpush
