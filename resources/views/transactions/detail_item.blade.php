@extends('layouts.app')

@section('content')
<?php
          if( !function_exists('ceiling') )
          {
              function ceiling($number, $significance = 1)
              {
                  return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
              }
          }
          ?>
<div class="row">
  <h3 class="page-header">Detail Transaksi <small>Rincian Pakaian</small></h3>
  <div class="col-md-8">
    <table class="table table-bordered">
      <tr>
        <th>Invoice No:</th>
        <td>{{$data_transaction['transaction']->invoice_number}}</td>
        <th>Tgl & Waktu Selesai:</th>
        <td>{{ date('d/m/Y', strtotime($data_transaction['transaction']->date_deliver)).' at:'.$data_transaction['transaction']->time_deliver}}</td>
      </tr>
      <tr>
        <th>Date Order:</th>
        <td>{{ date('d/m/Y', strtotime($data_transaction['transaction']->date_order))}}</td>
        <th>Petugas Penerima:</th>
        <td>{{$data_transaction['transaction']->username}}</td>
      </tr>
      <tr>
        <th>Nama Pelanggan:</th>
        <td colspan="3">{{$data_transaction['transaction']->name.' / '.$data_transaction['transaction']->phone.' / '.str_limit($data_transaction['transaction']->address, $limit = 20, $end = '...')}}</td>
      </tr>
      <tr>
        <th>Total QTY / Tipe Paket:</th>
        <td colspan="3">{{$data_transaction['total_qtys']}} / {{ ($data_transaction['type_paket'] == 1 ) ? 'Reguler' : 'Express' }}</td>
      </tr>
    </table>
  </div>
  <div>
    <div class="row">
      {!! Form::open(['route' => 'kasir.transaction.store_item','class' =>'form-horizontal']) !!}
      <div class="col-xs-4">
        <div class="col-xs-12">
          {!! Form::text('item',null,['id'=>'item', 'class'=>'form-control','placeholder'=>'Jenis Pakaian']) !!}
          {!! Form::hidden('item_id',null,['id'=>'item_id', 'class'=>'form-control','placeholder'=>'']) !!}
          {!! Form::hidden('transaction_id',$data_transaction['transaction']->id,['id'=>'transaction_id', 'class'=>'form-control']) !!}
          {!! Form::text('description',null,['id'=>'description', 'class'=>'form-control','placeholder'=>'Keterangan Pakaian','autocomplete'=>'off']) !!}
          {!! Form::text('qty',null,['id'=>'jumlah', 'class'=>'form-control','placeholder'=>'Jumlah','autocomplete'=>'off']) !!}
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
          <th>Jenis Pakaian</th>
          <th>Keterangan Pakaian</th>
          <th>Jumlah</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($data_transaction['item_transaction'] as $key=>$data)
        <tr>
          <td>{{ $key+1 }}</td>
          <td>{{ $data->name}}</td>
          <td>{{ $data->description}}</td>
          <td>{{ $data->qty }}</td>
          <td>
            {!! Form::open([
                'method' => 'DELETE',
                'route' => ['kasir.transaction.destroy_detail_item', $data->trans_item_id]
            ]) !!}
                {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-xs']) !!}
            {!! Form::close() !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

            
    <div class="col-md-4">
      <a href="{{route('kasir.transaction.detail',$data_transaction['transaction']->id)}}" class="btn btn-info"/>Back</a>
      <a class="btn btn-danger" href="{{ Route('kasir.transaction.print_item',$data_transaction['transaction']->id) }}" role="button">PRINT Rincian Pakaian</a>
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
