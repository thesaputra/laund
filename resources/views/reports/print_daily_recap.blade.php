<title>Laporan Uang Masuk</title>

<span style="font-size:15px; font-weight:bold;">Glory Laundry</span><br/>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
022-91323820, 0857 9444 0447
</address>
<div style="text-align:center;">
<span style="font-size:15px; font-weight:bold;">Laporan Uang Masuk</span><br/>
<span style="font-size:12px;">Periode: {{$date_start}} - {{$date_end}}</span><br/>
<br/>
</div>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Invoice</th>
      <th>Nama/Alamat</th>
      <th>Tgl Order</th>
      <th>Tgl Bayar</th>
      <th>Tgl Diambil</th>
      <th>Jumlah Uang Masuk</th>
    </tr>
  </thead>
  <tbody>
    <?php $total_uang_masuk = 0;?>
     <?php
          if( !function_exists('ceiling') )
          {
              function ceiling($number, $significance = 1)
              {
                  return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
              }
          }
          ?>
    @foreach ($data as $key=>$data)
    <tr>
      <td>{{ $key+1 }}</td>
      <td>{{ $data->invoice_number}}</td>
      <td>{{ $data->customer_name.' / '.$data->customer_address}}</td>
      <td>{{ date('d/m/Y', strtotime($data->date_order)) }}</td>
      <td>{{ date('d/m/Y', strtotime($data->created_at_payment)) }}</td>
      <td>{{ ($data->date_checkout == '0000-00-00') ? '-' : date('d/m/Y', strtotime($data->date_checkout)) }}</td>
      <td>
      {{ number_format(ceiling($data->amount_payment,100),0, ',', '.') }}</td>
    </tr>
    <?php $total_uang_masuk += $data->amount_payment; ?>
    @endforeach
    <tr style="font-weight:bold">
      <td colspan="6" align="right">
        Total Pemasukan:
      </td>
      <td>{{number_format(ceiling($total_uang_masuk,100),0, ',', '.')}}</td>
    </tr>
  </tbody>
</table>
<style type="text/css">
  table{
    border-collapse: collapse;
    border: 1px solid gray;
  }
  table td{
    border: 1px solid gray;
  }

  address {
    display: block;
    font-style: normal;
    font-size: 11px;
  }
</style>
