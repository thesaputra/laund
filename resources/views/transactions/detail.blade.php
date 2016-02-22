@extends('layouts.app')

@section('content')
<div class="row">
  <h3 class="page-header" id="detail-item">Detail Transaksi</h3>
  <div class="col-md-8">
  <?php
          if( !function_exists('ceiling') )
          {
              function ceiling($number, $significance = 1)
              {
                  return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
              }
          }
          ?>
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
  </div>
  <div>
    <div class="row">
      {!! Form::open(['route' => 'kasir.transaction.store_detail','class' =>'form-horizontal']) !!}
      <div class="col-xs-4">
        <div class="col-xs-12">
          {!! Form::open(['route' => 'kasir.transaction.store_detail','class' =>'form-horizontal']) !!}
          {!! Form::select('package_type', [
          '1' => 'Standard',
          '2' => 'Express'], null, ['id'=>'package_type', 'class'=>'form-control']
          ) !!}
          {!! Form::text('package',null,['id'=>'package', 'class'=>'form-control','placeholder'=>'Jenis Layanan']) !!}
          {!! Form::text('qty',null,['id'=>'jumlah', 'class'=>'form-control','placeholder'=>'Qty']) !!}
          {!! Form::hidden('package_id',null,['id'=>'package_id', 'class'=>'form-control','placeholder'=>'']) !!}
          {!! Form::hidden('transaction_id',$data_transaction['transaction']->id,['id'=>'transaction_id', 'class'=>'form-control']) !!}
          {!! Form::text('harga',null,['id'=>'harga', 'class'=>'form-control','placeholder'=>'Harga','readonly'=>'true']) !!}
          {!! Form::text('satuan',null,['id'=>'satuan', 'class'=>'form-control','placeholder'=>'Satuan','readonly'=>'true']) !!}
          <br/>
          <button type="submit" class="btn btn-primary col-md-12">Tambah</button>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <br/>
    <div class="tab-pane fade active in" id="home">
      <div class="row">
        <div class="col-sm-12">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Jenis Layanan</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Jumlah</th>
                <th>Action</th>
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
                <td align="right">{{ ($data->package_type == 1 ) ? number_format($data->price_regular, 2, ',', '.').' '.$data->unit :  number_format($data->price_express, 2, ',', '.').' '.$data->unit }}</td>
                <td align="right">{{ ($data->package_type == 1 ) ? number_format($data->price_regular*$data->qty, 2, ',', '.') :  number_format($data->price_express*$data->qty, 2, ',', '.') }}</td>
                <td>
                  {!! Form::open([
                    'method' => 'DELETE',
                    'route' => ['kasir.transaction.destroy_detail', $data->detail_id]
                    ]) !!}
                    {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-xs']) !!}
                    {!! Form::close() !!}
                  </td>
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
                  <th class="text-center" colspan="2">Reguler</th>
                  <th class="text-center" colspan="2">Express</th>
                  <th class="text-right">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Kg</td>
                  <td class="text-right">{{ $total_kg_reg }}</td>
                  <td class="text-right">{{ number_format($total_kg_reg_price, 2, ',', '.') }}</td>
                  <td class="text-right">{{ $total_kg_exp }}</td>
                  <td class="text-right">{{ number_format($total_kg_exp_price, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($total_kg_reg_price + $total_kg_exp_price, 2, ',', '.') }}</td>
                </tr>
                <tr>
                  <td>Mtr</td>
                  <td class="text-right">{{ $total_mtr_reg }}</td>
                  <td class="text-right">{{ number_format($total_mtr_reg_price, 2, ',', '.') }}</td>
                  <td class="text-right">{{ $total_mtr_exp }}</td>
                  <td class="text-right">{{ number_format($total_mtr_exp_price, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($total_mtr_exp_price + $total_mtr_reg_price, 2, ',', '.') }}</td>
                </tr>
                <tr>
                  <td>Pcs</td>
                  <td class="text-right">{{ $total_pcs_reg }}</td>
                  <td class="text-right">{{ number_format($total_pcs_reg_price, 2, ',', '.')}}</td>
                  <td class="text-right">{{ $total_pcs_exp }}</td>
                  <td class="text-right">{{ number_format($total_pcs_exp_price, 2, ',', '.') }}</td>
                  <td class="text-right">{{ number_format($total_pcs_exp_price + $total_pcs_reg_price, 2, ',', '.') }}</td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="5" align="right">
                    Total Bayar
                  </td>
                  <td class="text-right bg-warning">
                    <?php 
                      $ce = ($total_pcs_exp_price + $total_pcs_reg_price + $total_mtr_exp_price + $total_mtr_reg_price + $total_kg_reg_price + $total_kg_exp_price);
                       // echo number_format(ceiling($ce), 2, ',', '.');
                      // echo substr($ce,-2);
                      if (substr($ce, -2) == 00) {
                       echo number_format(ceiling($ce,-1), 2, ',', '.');
                      }
                       else
                       {
                         echo number_format(ceiling($ce,100), 2, ',', '.');
                       }
                      // echo $ce;
                      // if (intval($ce) == 55800) {
                      //   echo number_format(ceiling($ce-1), 2, ',', '.');
                      // }
                      // else 
                      // {
                      //   echo number_format(ceiling($ce,100), 2, ',', '.');
                      // }
                    ?>
                      
                    <!-- {{ number_format( ceiling($ce,100), 2, ',', '.') }} -->
                    
                  </td>
                </tr>
              </tfoot>
            </table>
            <h4 class="page-header" id="history-payment">History Pembayaran</h4>
            <div class="col-md-8">
              <table class="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Tanggal Transaksi</th>
                    <th>Keterangan Pembayaran</th>
                    <th class="text-right">Jumlah</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $total_bayar = 0; ?>
                  @foreach ($data_transaction['payment_histories'] as $key=>$data)
                  <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ date('d/m/Y', strtotime($data->payment_date))}}</td>
                    <td>{{ $data->description}}</td>
                    <td class="text-right">{{ number_format($data->amount, 2, ',', '.')}}</td>
                    <td>
                      {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['kasir.transaction.destroy_history_payment', $data->id]
                        ]) !!}
                        {!! Form::submit('Hapus', ['class' => 'btn btn-danger btn-xs']) !!}
                        {!! Form::close() !!}
                      </td>
                    </tr>
                    <?php $total_bayar += $data->amount;?>
                    @endforeach
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3" align="right">
                        Total Bayar
                      </td>
                      <td class="text-right bg-success">
                        {{ number_format(ceiling($total_bayar,100), 2, ',', '.') }}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3" align="right">
                        Diskon
                      </td>
                      <td class="text-right bg-success">
                        {{ number_format($data_transaction['transaction']->discount, 2, ',', '.') }}
                      </td>
                    </tr>
                    <tr>
                      <td colspan="3" align="right">
                        Sisa Bayar
                      </td>
                      <td class="text-right bg-danger">
                      <?php 
                        $aa = (ceiling(($total_pcs_exp_price + $total_pcs_reg_price + $total_mtr_exp_price + $total_mtr_reg_price + $total_kg_reg_price + $total_kg_exp_price) - $total_bayar - $data_transaction['transaction']->discount,100));
                        if ($aa <= 100) {
                          echo '0,00';
                        } else {
                          echo number_format((($total_pcs_exp_price + $total_pcs_reg_price + $total_mtr_exp_price + $total_mtr_reg_price + $total_kg_reg_price + $total_kg_exp_price) - $total_bayar - $data_transaction['transaction']->discount), 2, ',', '.');
                        }
                        ?>
                      </td>
                    </tr>
                  </tfoot>
                </table>
              </div>
              <div class="col-md-4">
                <div class="row">
                  {!! Form::open(['route' => 'kasir.transaction.store_payment','class' =>'form-horizontal']) !!}
                  <div class="col-xs-12">
                    {!! Form::text('payment_date',null,['id'=>'payment_date', 'class'=>'form-control','placeholder'=>'Tanggal','autocomplete'=>'off','required'=>'true']) !!}
                    {!! Form::text('description',null,['id'=>'description', 'class'=>'form-control','placeholder'=>'Keterangan Pembayaran','autocomplete'=>'off','required'=>'true']) !!}
                    {!! Form::hidden('transaction_id',$data_transaction['transaction']->id,['id'=>'transaction_id', 'class'=>'form-control']) !!}
                    {!! Form::text('amount',null,['id'=>'amount', 'class'=>'form-control','placeholder'=>'Jumlah Bayar','autocomplete'=>'off','required'=>'true']) !!}
                    <br/>
                    <button type="submit" class="btn btn-primary col-xs-12">Simpan Transaksi</button>
                  </div>
                  {!! Form::close() !!}
                </div>
              </div>
            </div>
            <div class="col-md-6 text-left">
              <br/>
              <div class="col-md-2">
                <a href="{{route('kasir.transaction')}}" class="btn btn-info"/>Back</a>
              </div>
              <div class="col-md-4">
                <a class="btn btn-warning" href="{{ Route('kasir.transaction.detail_user',$data_transaction['transaction']->id.'#tab1default') }}" role="button">+ Petugas Layanan</a>
              </div>
              <div class="col-md-4">
                <a class="btn btn-success" href="{{ Route('kasir.transaction.detail_item',$data_transaction['transaction']->id) }}" role="button">+ Rincian Pakaian</a>
              </div>
            </div>
            <div class="col-md-6 text-right">
              <br/>
              <div class="col-md-12">
                <a class="btn btn-warning" href="{{ Route('kasir.transaction.print_item',$data_transaction['transaction']->id) }}" role="button">PRINT Rincian Pakaian</a>

                <a class="btn btn-danger" href="{{ Route('kasir.transaction.print_invoice',$data_transaction['transaction']->id) }}" role="button">PRINT INVOICE</a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <script>
      $(document).ready(function() {
        $('#payment_date').datepicker({
    format: "dd/mm/yyyy",
    language: "id"
  });
        autocomplete_package();

        //   var val_left = $('#amount_left').val();
        //
        //   var result = 0;
        //   $('#amount_dp').on('input', function() {
        //     if (this.value != "")
        //     {
        //       var discount = $('#discount').val();
        //
        //       var early_dp = "{{$data_transaction['transaction']->amount_dp}}";
        //       var result = parseFloat(early_dp) + (parseFloat(val_left) - parseFloat(this.value));
        //       var after_disc = result - parseFloat(discount);
        //       $('#amount_left').val(after_disc.toFixed(2));
        //     } else {
        //
        //     }
        //   });
        //
        //   $('#discount').on('input', function() {
        //     if (this.value != "")
        //     {
        //       var val_dp = $('#amount_dp').val();
        //
        //       var early_dp = "{{$data_transaction['transaction']->amount_dp}}";
        //       var result = (parseFloat(val_left) - (parseFloat(this.value) + parseFloat(val_dp) - parseFloat(early_dp)));
        //       $('#amount_left').val(result.toFixed(2));
        //     }
        //   });
        //
        //   $('#discount').change('input', function() {
        //     if (this.value == "")
        //     {
        //       $('#discount').val(0);
        //     }
        //   });
        });

        $( "#package_type" ).change(function() {
          $('#package').val('');
          $('#harga').val('');
          $('#jumlah').val('');
          $('#satuan').val('');
        });

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
                url: '{!! route("kasir.transaction.package_autocomplete_trans") !!}',
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

        </script>

        @endsection
