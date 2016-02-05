<title>Laporan Revenue</title>

<span style="font-size:15px; font-weight:bold;">Glory Laundry</span><br/>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
022-91323820, 0857 9444 0447
</address>
<div style="text-align:center;">
<span style="font-size:15px; font-weight:bold;">Laporan Revenue</span><br/>
<span style="font-size:12px;">Periode: {{$date_start}} - {{$date_end}}</span><br/>
<br/>
</div>
<p>Pemasukan:</p>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Keterangan</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <?php $total = 0;?>
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
      <td>{{ date('d/m/Y', strtotime($data->trans_date)) }}</td>
      <td>{{ $data->description}}</td>
      <td>{{ number_format(($data->price_income),2, ',', '.')}}</td>
    </tr>
    <?php $total += $data->price_income; ?>
    @endforeach
    <tr style="font-weight:bold">
      <td colspan="3" align="right">
        Total Pemasukan:
      </td>
      <td>{{number_format(($total),2, ',', '.') }}</td>
    </tr>
  </tbody>
</table>


<p>Pengeluaran:</p>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Tanggal</th>
      <th>Keterangan</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <?php $total2 = 0;?>
     <?php
          if( !function_exists('ceiling') )
          {
              function ceiling($number, $significance = 1)
              {
                  return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
              }
          }
          ?>
    @foreach ($data_out as $key=>$data)
    <tr>
      <td>{{ $key+1 }}</td>
      <td>{{ date('d/m/Y', strtotime($data->trans_date)) }}</td>
      <td>{{ $data->description}}</td>
      <td>{{ number_format(($data->price_income),2, ',', '.')}}</td>
    </tr>
    <?php $total2 += $data->price_income; ?>
    @endforeach
    <tr style="font-weight:bold">
      <td colspan="3" align="right">
        Total Pengeluaran:
      </td>
      <td>{{number_format(($total2),2, ',', '.') }}</td>
    </tr>
  </tbody>
</table>
<p style="float:right;font-weight:bold"><u>Revenue: {{ number_format(($total - $total2),2, ',', '.')  }}</u></p>
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
