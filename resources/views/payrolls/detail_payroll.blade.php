@extends('layouts.app')

@section('content')
<div class="row">
  <h3 class="page-header">Detail Payroll</h3>
  <div class="col-md-8">
    <table class="table table-bordered">
      <tr>
        <th>Tanggal Payroll:</th>
        <td>{{ date('d/m/Y', strtotime($transaction_payrolls->payroll_date))}}</td>
      </tr>
      <tr>
        <th>Nama:</th>
        <td>{{$transaction_payrolls->name}}</td>
      </tr>
       <tr>
        <th>Keterangan:</th>
        <td>{{$transaction_payrolls->description}}</td>
      </tr>
    </table>
  </div>
  <div>
    <div class="row">
      {!! Form::open(['route' => 'payroll.store_payroll','class' =>'form-horizontal']) !!}
      <div class="col-xs-4">
        <div class="col-xs-12">
          {!! Form::text('desc_payroll',null,['id'=>'desc_payroll', 'class'=>'form-control','placeholder'=>'Pekerjaan']) !!}
          {!! Form::hidden('transaction_payroll_id',$transaction_payrolls->id,['id'=>'transaction_payroll_id', 'class'=>'form-control']) !!}
          {!! Form::text('jenis_satuan',null,['id'=>'jenis_satuan', 'class'=>'form-control','placeholder'=>'Jenis Pekerjaan','autocomplete'=>'off']) !!}
          {!! Form::text('qty',null,['id'=>'qty', 'class'=>'form-control','placeholder'=>'Qty','autocomplete'=>'off']) !!}
          {!! Form::text('satuan',null,['id'=>'satuan', 'class'=>'form-control','placeholder'=>'Satuan','autocomplete'=>'off']) !!}
          {!! Form::text('amount',null,['id'=>'upah', 'class'=>'form-control','placeholder'=>'Upah','autocomplete'=>'off']) !!}
          <br/>
          <button type="submit" class="btn btn-primary col-xs-12">Tambah</button>
        </div>
      </div>

      {!! Form::close() !!}
    </div>
    <br/>
    <table class="table table-striped table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Pekerjaan</th>
          <th>Jenis Pekerjaan</th>
          <th>Qty</th>
          <th>Satuan</th>
          <th>Upah</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list_detail as $key=>$data)
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $data->desc_payroll}}</td>
          <td>{{ $data->jenis_satuan}}</td>
          <td>{{ $data->qty }}</td>
          <td>{{ $data->satuan}}</td>
          <td>{{ number_format($data->amount) }}</td>
          <td>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['payroll.destroy_detail_payroll', $data->id]
            ]) !!}
                {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="col-md-4">
      <a href="{{route('payroll.payroll')}}" class="btn btn-info"/>Back</a>
    </div>
  </div>


  <script>
  $(document).ready(function() {
    autocomplete_item();

    $('#item').focus();
  });

  function autocomplete_item(){
    var substringMatcher = function(strs) {
      return function findMatches(q, cb) {
        var matches, substringRegex;
        matches = [];
        substrRegex = new RegExp(q, 'i');
        $.each(strs, function(i, str) {
          if (substrRegex.test(str)) {
            matches.push(str);
          }
        });
        cb(matches);
      };
    };

    var arr1 = [];
    $("#item").typeahead({
      hint: false,
      highlight: true,
      minLength: 2

    },
    {
      limit: 50,
      async: true,
      templates: {notFound:"Data not found"},
      source: function (query, processSync, processAsync) {
        return $.ajax({
          url: '{!! route("kasir.transaction.item_autocomplete") !!}',
          type: 'GET',
          data: {"term": query},
          dataType: 'json',
          success: function (json) {
            var _tmp_arr = [];
            json.map(function(item){
              _tmp_arr.push(item.name)
              arr1.push({id: item.id, st: item.name})
            })
            return processAsync(_tmp_arr);
          }
        });
      }
    })
    $("#item").on('typeahead:selected', function (e, code) {
      arr1.map(function(i){
        if (i.st == code){
          $("#item_id").val(i.id);
        }
      })

      if(e.keyCode==13){
        arr1.map(function(i){
          if (i.st == code){
            $("#item_id").val(i.id);
          }
        })
      }
    })
  }
  </script>

  @endsection
