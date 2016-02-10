@extends('layouts.app')

@section('content')
<div class="row">
  <h3 class="page-header">Transaksi Payroll Baru</h3>

  {!! Form::model($transaction_payroll,['method' => 'PATCH','route'=>['payroll.payroll.update',$transaction_payroll->id]]) !!}
  <div class="row">
    <div class="col-md-4">
      <div class="form-group">
        {!! Form::label('payroll_date', 'Date Payroll:') !!}
        {!! Form::text('payroll_date',null,['id'=>'date-payroll', 'class'=>'form-control']) !!}
      </div>
    </div>
    
 </div>
 <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('user_id', 'Nama Pegawai:') !!}
      {!! Form::text('user',$user->name,['id'=>'user', 'class'=>'form-control','placeholder'=>'Enter name']) !!}
      {!! Form::hidden('user_id',$user->id,['id'=>'user_id', 'class'=>'form-control']) !!}
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('address', 'Alamat Pegawai:') !!}
      <input type="text" id="address" class="form-control" readonly="true" value='<?=$user->address?>'></input>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('phone', 'Telepon Pegawai:') !!}
      <input type="text" id="phone" class="form-control" readonly="true" value='<?=$user->phone?>'></input>
    </div>
  </div>
  <div class="col-md-4">
    <div class="form-group">
      {!! Form::label('description', 'Keterangan:') !!}
      {!! Form::text('description',null,['id'=>'keterangan', 'class'=>'form-control','placeholder'=>'']) !!}
    </div>
  </div>
</div>

<br/>

<div class="row">
  <div class="col-md-10">
    <a href="{{route('payroll.payroll')}}" class="btn btn-info"/>Back</a>
  </div>
  <div class="col-md-2">
    {!! Form::submit('Update', ['class' => 'btn btn-success form-control']) !!}
  </div>
</div>

{!! Form::close() !!}
</div>
<script>
  $(document).ready(function() {
   

  date_deliver = '{{ $transaction_payroll->payroll_date}}'
  split_deliver = date_deliver.split('-');
  date = split_deliver[2];
  month = split_deliver[1];
  year = split_deliver[0];
  $('#date-payroll').val(date+'/'+month+'/'+year);

   $('#date-payroll').datepicker({
      format: "dd/mm/yyyy",
      language: "id"
    });
    autocomplete_user();
  });


  function autocomplete_user(){
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
    $("#user").typeahead({
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
          url: '{!! route("kasir.transaction.user_autocomplete") !!}',
          type: 'GET',
          data: {"term": query},
          dataType: 'json',
          success: function (json) {
            var _tmp_arr = [];
            json.map(function(item){
              _tmp_arr.push(item.name)
              arr1.push({id: item.id, st: item.name, ad: item.address, p: item.phone})
            })
            return processAsync(_tmp_arr);
          }
        });
      }
    })
    $("#user").on('typeahead:selected', function (e, code) {
      arr1.map(function(i){
        if (i.st == code){
          $("#user_id").val(i.id);
          $("#address").val(i.ad);
          $("#phone").val(i.p);
        }
      })

      if(e.keyCode==13){
        arr1.map(function(i){
          if (i.st == code){
            $("#user_id").val(i.id);
            $("#address").val(i.ad);
            $("#phone").val(i.p);
          }
          else {
            $("#user").val('');
          }
        })
      }
    })
  }
</script>
@endsection
