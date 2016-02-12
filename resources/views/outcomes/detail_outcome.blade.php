@extends('layouts.app')

@section('content')
<div class="row">
  <h3 class="page-header">Detail Pengeluaran</h3>
  <div class="col-md-8">
    <table class="table table-bordered">
      <tr>
        <th>Tanggal Pengeluaran:</th>
        <td>{{ date('d/m/Y', strtotime($detail_outcome->trans_date))}}</td>
      </tr>
      <tr>
        <th>Nama Toko:</th>
        <td>{{$detail_outcome->store_name}}</td>
      </tr>
       <tr>
        <th>Tlp Toko:</th>
        <td>{{$detail_outcome->store_tlp}}</td>
      </tr>
    </table>
  </div>
  <div>
    <div class="row">
      {!! Form::open(['route' => 'outcome.store_outcome','class' =>'form-horizontal']) !!}
      <div class="col-xs-4">
        <div class="col-xs-12">
          {!! Form::text('desc_outcome',null,['id'=>'desc_payroll', 'class'=>'form-control','placeholder'=>'Nama Pengeluaran']) !!}
          {!! Form::hidden('outcome_id',$detail_outcome->id,['id'=>'outcome_id', 'class'=>'form-control']) !!}
          {!! Form::text('qty',null,['id'=>'jenis_satuan', 'class'=>'form-control','placeholder'=>'QTY','autocomplete'=>'off']) !!}
          {!! Form::text('price',null,['id'=>'upah', 'class'=>'form-control','placeholder'=>'Harga','autocomplete'=>'off']) !!}
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
          <th>Nama Pengeluaran</th>
          <th>Qty</th>
          <th>Price</th>
          <th>Jumlah</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($list_detail as $key=>$data)
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $data->desc_outcome}}</td>
          <td>{{ $data->qty }}</td>
          <td>{{ number_format($data->price) }}</td>
          <td>{{ number_format($data->price * $data->qty)}}</td>
          
          <td>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['outcome.destroy_detail_outcome', $data->id]
            ]) !!}
                {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="col-md-4">
      <a href="{{route('outcome.outcome')}}" class="btn btn-info"/>Back</a>
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
