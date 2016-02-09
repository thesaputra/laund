@extends('layouts.app')

@section('content')
<div class="row" id="top">
  <h3 class="page-header">Detail Transaksi <small>Petugas Layanan</small></h3>
  <div class="col-md-12">
    <div class="panel with-nav-tabs panel-info">
      <div class="panel-heading">
        <ul class="nav nav-tabs">
          <li class="tab1"><a href="#tab1default" data-toggle="tab" id="tab1defaultH">Standard</a></li>
          <li class="tab2"><a href="#tab2default" data-toggle="tab" id=tab2defaultH>Khusus PCS & MTR</a></li>
        </ul>
      </div>
      <div class="panel-body">
        <div class="tab-content">
          <div class="tab-pane fade in active" id="tab1default">
            <!--  start -->
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
              </table>


              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Jenis Layanan</th>
                    <th class="text-center">Qty</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $total_kg_reg = 0;
                  $total_kg_reg_price = 0;

                  $total_mtr_reg = 0;
                  $total_mtr_reg_price = 0;

                  $total_pcs_reg = 0;
                  $total_pcs_reg_price = 0;

                  $total_kg_exp = 0;
                  $total_kg_exp_price = 0;

                  $total_mtr_exp = 0;
                  $total_mtr_exp_price = 0;

                  $total_pcs_exp = 0;
                  $total_pcs_exp_price = 0;
                  ?>
                  @foreach ($data_transaction['detail_transaction'] as $key=>$data)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ ($data->package_type == 1 ) ? 'Reg'.'-'.$data->name : 'Exp'.'-'.$data->name }}</td>
                    <td align="center">{{ $data->qty }}</td>
                    </tr>
                    <?php
                    if ($data->package_type == 1) {
                      if (($data->unit) == 'Kg') {
                        $total_kg_reg += $data->qty;
                        $total_kg_reg_price += $data->qty * $data->price_regular;
                      }
                      if (($data->unit) == 'Pcs') {
                        $total_pcs_reg += $data->qty;
                        $total_pcs_reg_price += $data->qty * $data->price_regular;
                      }
                      if (($data->unit) == 'Mtr') {
                        $total_mtr_reg += $data->qty;
                        $total_mtr_reg_price += $data->qty * $data->price_regular;
                      }

                    } else {
                      if (($data->unit) == 'Kg') {
                        $total_kg_exp += $data->qty;
                        $total_kg_exp_price += $data->qty * $data->price_express;
                      }
                      if (($data->unit) == 'Pcs') {
                        $total_pcs_exp += $data->qty;
                        $total_pcs_exp_price += $data->qty * $data->price_express;
                      }
                      if (($data->unit) == 'Mtr') {
                        $total_mtr_exp += $data->qty;
                        $total_mtr_exp_price += $data->qty * $data->price_express;
                      }
                    }
                    ?>
                    @endforeach
                  </tbody>
                </table>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>Satuan</th>
                      <th class="text-center">Reguler</th>
                      <th class="text-center">Express</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Kg</td>
                      <td class="text-right">{{ $total_kg_reg }}</td>
                      <td class="text-right">{{ $total_kg_exp }}</td>
                    </tr>
                    <tr>
                      <td>Mtr</td>
                      <td class="text-right">{{ $total_mtr_reg }}</td>
                      <td class="text-right">{{ $total_mtr_exp }}</td>
                    </tr>
                    <tr>
                      <td>Pcs</td>
                      <td class="text-right">{{ $total_pcs_reg }}</td>
                      <td class="text-right">{{ $total_pcs_exp }}</td>
                    </tr>
                  </tbody>
                </table>
            </div>
            <div>
              <div class="row">
                {!! Form::open(['route' => 'kasir.transaction.store_user','class' =>'form-horizontal']) !!}
                <div class="col-xs-4">
                  <div class="col-xs-12">
                    {!! Form::text('user',null,['id'=>'user', 'class'=>'form-control','placeholder'=>'Nama Pekerja']) !!}
                    {!! Form::hidden('user_id',null,['id'=>'user_id', 'class'=>'form-control','placeholder'=>'']) !!}
                    {!! Form::hidden('transaction_id',$data_transaction['transaction']->id,['id'=>'transaction_id', 'class'=>'form-control']) !!}
                    {!! Form::text('package',null,['id'=>'package', 'class'=>'form-control','placeholder'=>'Jenis Layanan Non PCS']) !!}
                    {!! Form::hidden('package_id',null,['id'=>'package_id', 'class'=>'form-control','placeholder'=>'']) !!}
                    {!! Form::text('start_date',null,['id'=>'start_date', 'class'=>'form-control','placeholder'=>'Tgl Mulai']) !!}
                    {!! Form::text('end_date',null,['id'=>'start_date', 'class'=>'form-control','placeholder'=>'Tgl Selesai']) !!}
                    {!! Form::text('qty',null,['id'=>'jumlah', 'class'=>'form-control','placeholder'=>'Qty']) !!}

                    {!! Form::select('unit', [
                    'Kg' => 'Kg',
                    'Mtr' => 'Mtr',
                    'Hari' => 'Hari'],
                    null, ['class'=>'form-control']
                    ) !!}
                    {!! Form::select('status', [
                    'Proses' => 'Proses',
                    'Selesai' => 'Selesai'],
                    null, ['class'=>'form-control']
                    ) !!}
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
                    <th>Nama Petugas</th>
                    <th>Layanan</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Tgl Pengerjaan</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data_transaction['user_transaction'] as $key=>$data)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $data->name}}</td>
                    <td>{{ $data->package_name}}</td>
                    <td>{{ $data->qty}}</td>
                    <td>{{ $data->unit }}</td>
                    <td>{{ date('d/m/Y H:m', strtotime($data->start_date)).' - '.date('d/m/Y H:m', strtotime($data->end_date))}}</td>
                    <td>
                      {!! Form::open([
                        'method' => 'PATCH',
                        'route' => ['kasir.transaction.update_status', $data->trans_user_id]
                        ]) !!}
                        {!! Form::hidden('status',$data->status,['id'=>'status', 'class'=>'form-control']) !!}
                        {!! Form::submit($data->status, ['class' => 'btn btn-default btn-xs']) !!}
                        {!! Form::close() !!}
                      </td>
                      <td>
                        {!! Form::open([
                          'method' => 'DELETE',
                          'route' => ['kasir.transaction.destroy_detail_user', $data->trans_user_id]
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
                  </div>
                </div>
                <!-- end -->
              </div>
              <div class="tab-pane fade" id="tab2default">
                <div class="row">
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
                  </table>

                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Jenis Layanan</th>
                        <th class="text-center">Qty</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $total_kg_reg = 0;
                      $total_kg_reg_price = 0;

                      $total_mtr_reg = 0;
                      $total_mtr_reg_price = 0;

                      $total_pcs_reg = 0;
                      $total_pcs_reg_price = 0;

                      $total_kg_exp = 0;
                      $total_kg_exp_price = 0;

                      $total_mtr_exp = 0;
                      $total_mtr_exp_price = 0;

                      $total_pcs_exp = 0;
                      $total_pcs_exp_price = 0;
                      ?>
                      @foreach ($data_transaction['detail_transaction'] as $key=>$data)
                      <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ ($data->package_type == 1 ) ? 'Reg'.'-'.$data->name : 'Exp'.'-'.$data->name }}</td>
                        <td align="center">{{ $data->qty }}</td>
                        </tr>
                        <?php
                        if ($data->package_type == 1) {
                          if (($data->unit) == 'Kg') {
                            $total_kg_reg += $data->qty;
                            $total_kg_reg_price += $data->qty * $data->price_regular;
                          }
                          if (($data->unit) == 'Pcs') {
                            $total_pcs_reg += $data->qty;
                            $total_pcs_reg_price += $data->qty * $data->price_regular;
                          }
                          if (($data->unit) == 'Mtr') {
                            $total_mtr_reg += $data->qty;
                            $total_mtr_reg_price += $data->qty * $data->price_regular;
                          }

                        } else {
                          if (($data->unit) == 'Kg') {
                            $total_kg_exp += $data->qty;
                            $total_kg_exp_price += $data->qty * $data->price_express;
                          }
                          if (($data->unit) == 'Pcs') {
                            $total_pcs_exp += $data->qty;
                            $total_pcs_exp_price += $data->qty * $data->price_express;
                          }
                          if (($data->unit) == 'Mtr') {
                            $total_mtr_exp += $data->qty;
                            $total_mtr_exp_price += $data->qty * $data->price_express;
                          }
                        }
                        ?>
                        @endforeach
                      </tbody>
                    </table>
                    <table class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Satuan</th>
                          <th class="text-center">Reguler</th>
                          <th class="text-center">Express</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Kg</td>
                          <td class="text-right">{{ $total_kg_reg }}</td>
                          <td class="text-right">{{ $total_kg_exp }}</td>
                        </tr>
                        <tr>
                          <td>Mtr</td>
                          <td class="text-right">{{ $total_mtr_reg }}</td>
                          <td class="text-right">{{ $total_mtr_exp }}</td>
                        </tr>
                        <tr>
                          <td>Pcs</td>
                          <td class="text-right">{{ $total_pcs_reg }}</td>
                          <td class="text-right">{{ $total_pcs_exp }}</td>
                        </tr>
                      </tbody>
                    </table>

                </div>
                <div class="col-md-4">
                  <div class="row">
                    {!! Form::open(['route' => 'kasir.transaction.store_pcs','class' =>'form-horizontal']) !!}
                    <div class="col-xs-12">
                      {!! Form::text('user',null,['id'=>'user_pcs', 'class'=>'form-control','placeholder'=>'Nama Pekerja']) !!}
                      {!! Form::hidden('user_id',null,['id'=>'user_id_pcs', 'class'=>'form-control','placeholder'=>'']) !!}
                      {!! Form::hidden('transaction_id',$data_transaction['transaction']->id,['id'=>'transaction_id', 'class'=>'form-control']) !!}
                      {!! Form::text('package',null,['id'=>'package_pcs', 'class'=>'form-control','placeholder'=>'Jenis Layanan PCS/MTR']) !!}
                      {!! Form::hidden('package_id',null,['id'=>'package_id_pcs', 'class'=>'form-control','placeholder'=>'']) !!}
                      {!! Form::text('start_date',null,['id'=>'start_date', 'class'=>'form-control','placeholder'=>'Tgl Mulai']) !!}
                      {!! Form::text('end_date',null,['id'=>'start_date', 'class'=>'form-control','placeholder'=>'Tgl Selesai']) !!}
                      {!! Form::text('qty',null,['id'=>'jumlah', 'class'=>'form-control','placeholder'=>'Qty']) !!}
                      {!! Form::hidden('price_reg',null,['id'=>'price_reg_pcs', 'class'=>'form-control','placeholder'=>'Price']) !!}
                      {!! Form::hidden('price_exp',null,['id'=>'price_exp_pcs', 'class'=>'form-control','placeholder'=>'Price']) !!}

                      {!! Form::select('package_detail', [
                      'Tag' => 'Tag Satuan',
                      'Cuci' => 'Cuci Operasional Satuan',
                      'Setrika' => 'Setrika Operasional Satuan',
                      'Qc' => 'Qc Satuan',
                      'Packing' => 'Packing Satuan'
                      ],
                      null, ['class'=>'form-control']
                      ) !!}

                      {!! Form::select('package_type', [
                      '1' => 'Reguler',
                      '2' => 'Express'],
                      null, ['class'=>'form-control']
                      ) !!}

                      {!! Form::hidden('unit',null,['id'=>'unit', 'class'=>'form-control','placeholder'=>'']) !!}

                      {!! Form::select('status', [
                      'Proses' => 'Proses',
                      'Selesai' => 'Selesai'],
                      null, ['class'=>'form-control']
                      ) !!}
                      {!! Form::text('description',null,['id'=>'description', 'class'=>'form-control','placeholder'=>'Keterangan']) !!}

                      <br/>
                      <button type="submit" class="btn btn-primary col-xs-12">Tambah</button>
                    </div>

                    {!! Form::close() !!}
                  </div>
                </div>
              </div>
                <br/>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Petugas</th>
                      <th>Layanan</th>
                      <th>Task</th>
                      <th>Qty</th>
                      <th>Satuan</th>
                      <th>Tgl Pengerjaan</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data_transaction['pcs_transaction'] as $key=>$data)
                    <tr>
                      <td>{{ $key+1 }}</td>
                      <td>{{ $data->name}}</td>
                      <td>{{ $data->package_name}}</td>
                      <td>{{ $data->package_detail}}</td>
                      <td>{{ $data->qty}}</td>
                      <td>{{ $data->unit }}</td>
                      <td>{{ date('d/m/Y H:m', strtotime($data->start_date)).' - '.date('d/m/Y H:m', strtotime($data->end_date))}}</td>
                      <td>
                        {!! Form::open([
                          'method' => 'PATCH',
                          'route' => ['kasir.transaction.update_status_pcs', $data->trans_user_id]
                          ]) !!}
                          {!! Form::hidden('status',$data->status,['id'=>'status', 'class'=>'form-control']) !!}
                          {!! Form::submit($data->status, ['class' => 'btn btn-default btn-xs']) !!}
                          {!! Form::close() !!}
                        </td>
                        <td>
                          {!! Form::open([
                            'method' => 'DELETE',
                            'route' => ['kasir.transaction.destroy_detail_user_pcs', $data->trans_user_id]
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>




    <script>
    $(document).ready(function() {
      $("html, body").animate({
      scrollTop:0
      },"slow");


      $( "#tab1defaultH" ).click(function() {
        window.location.href = "/kasir/transaction/detail_user/{{$data_transaction['transaction']->id}}#tab1default";
        $("html, body").animate({
        scrollTop:0
        },"slow");
      });
      $( "#tab2defaultH" ).click(function() {
        window.location.href = "/kasir/transaction/detail_user/{{$data_transaction['transaction']->id}}#tab2default";
        $("html, body").animate({
        scrollTop:0
        },"slow");
      });

      var leftUrl = window.location.href
      var x = leftUrl.split("#");
      // alert(x[1]);
      switch (x[1]) {
    case 'tab1default':
       $('.nav-tabs > li.tab1').addClass('active');
         $('.nav-tabs > li.tab2').removeClass('active');


               $('#tab1default').addClass('active in');
               $('#tab2default').removeClass('active');

       break;
    case 'tab2default':
      $('.nav-tabs > li.tab2').addClass('active');
      $('.nav-tabs > li.tab1').removeClass('active');

      $('#tab2default').addClass('active in');
      $('#tab1default').removeClass('active');


       break;
}

      autocomplete_user();
      autocomplete_package();
      autocomplete_user_pcs();
      autocomplete_package_pcs();

      $('#start_date,#end_date').datetimepicker({
        locale: 'id',
        format: "DD/MM/YYYY hh:mm"
      });
      $('#user').focus();
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
                arr1.push({id: item.id, st: item.name})
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
          }
        })

        if(e.keyCode==13){
          arr1.map(function(i){
            if (i.st == code){
              $("#user_id").val(i.id);
            }
            else {
              $("#user").val('');
            }
          })
        }
      })
    }

    function autocomplete_package(){
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
      $("#package").typeahead({
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
            url: '{!! route("kasir.transaction.package_autocomplete") !!}',
            type: 'GET',
            data: {"term": query},
            dataType: 'json',
            success: function (json) {
              var _tmp_arr = [];
              json.map(function(item){
                _tmp_arr.push(item.name)
                arr1.push({id: item.id, st: item.name, price_regular: item.price_regular, price_express: item.price_express,satuan: item.unit})
              })
              return processAsync(_tmp_arr);
            }
          });
        }
      })
      $("#package").on('typeahead:selected', function (e, code) {
        arr1.map(function(i){
          if (i.st == code){
            $("#package_id").val(i.id);
            $("#satuan").val(i.satuan);
            if($('#package_type option:selected').val() == 1) {
              $("#harga").val(i.price_regular);
            }
            else {
              $("#harga").val(i.price_express);
            }
          }
        })

        if(e.keyCode==13){
          arr1.map(function(i){
            if (i.st == code){
              $("#package_id").val(i.id);
              $("#satuan").val(i.satuan);
              if($('#package_type option:selected').val() == 1) {
                $("#harga").val(i.price_regular);
              }
              else {
                $("#harga").val(i.price_express);
              }
            }
          })
        }
      })
    }


    // end
    function autocomplete_user_pcs(){
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
      $("#user_pcs").typeahead({
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
                arr1.push({id: item.id, st: item.name})
              })
              return processAsync(_tmp_arr);
            }
          });
        }
      })
      $("#user_pcs").on('typeahead:selected', function (e, code) {
        arr1.map(function(i){
          if (i.st == code){
            $("#user_id_pcs").val(i.id);
          }
        })

        if(e.keyCode==13){
          arr1.map(function(i){
            if (i.st == code){
              $("#user_id_pcs").val(i.id);
            }
            else {
              $("#user_pcs").val('');
            }
          })
        }
      })
    }

    function autocomplete_package_pcs(){
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
      $("#package_pcs").typeahead({
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
            url: '{!! route("kasir.transaction.package_autocomplete_pcs") !!}',
            type: 'GET',
            data: {"term": query},
            dataType: 'json',
            success: function (json) {
              var _tmp_arr = [];
              json.map(function(item){
                _tmp_arr.push(item.name)
                arr1.push({id: item.id, st: item.name, price_regular: item.price_regular, price_express: item.price_express,satuan: item.unit})
              })
              return processAsync(_tmp_arr);
            }
          });
        }
      })
      $("#package_pcs").on('typeahead:selected', function (e, code) {
        arr1.map(function(i){
          // console.log(i);
          if (i.st == code){
            $("#package_id_pcs").val(i.id);
            $("#price_reg_pcs").val(i.price_regular);
            $("#price_exp_pcs").val(i.price_express);
            $("#unit").val(i.satuan);


            if($('#package_type option:selected').val() == 1) {
              $("#harga").val(i.price_regular);
            }
            else {
              $("#harga").val(i.price_express);
            }
          }
        })

        if(e.keyCode==13){
          arr1.map(function(i){
            if (i.st == code){
              $("#package_id_pcs").val(i.id);
              $("#satuan").val(i.satuan);
              if($('#package_type option:selected').val() == 1) {
                $("#harga").val(i.price_regular);
              }
              else {
                $("#harga").val(i.price_express);
              }
            }
          })
        }
      })
    }
    </script>

    @endsection
