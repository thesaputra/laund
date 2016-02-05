<title>Laporan Payroll</title>

<span style="font-size:15px; font-weight:bold;">Glory Laundry</span><br/>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
022-91323820, 0857 9444 0447
</address>
<div style="text-align:center;">
<span style="font-size:15px; font-weight:bold;">Laporan Payroll</span><br/>
<span style="font-size:12px;">Periode: {{$date_start}} - {{$date_end}}</span><br/>
<br/>
</div>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Payroll date</th>
      <th>Nama Pegawai</th>
      <th>Bagian</th>
      <th>Keterangan</th>
      <th>Gaji</th>
      <th>Bonus</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php $total_gpk_bonus = 0;?>
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
      <td>{{ date('d/m/Y', strtotime($data->payroll_date)) }}</td>
      <td>{{ $data->name}}</td>
      <td>{{ $data->depart}}</td>
      <td>{{ $data->description}}</td>
      <td>{{ number_format(($data->gpk),2, ',', '.')}}</td>
      <td>{{ number_format(($data->bonus),2, ',', '.')}}</td>
      <td>{{ number_format(($data->gpk + $data->bonus),2, ',', '.')}}</td>
    </tr>
    <?php $total_gpk_bonus += ($data->gpk + $data->bonus); ?>
    @endforeach
    <tr style="font-weight:bold">
      <td colspan="7" align="right">
        Total Pengeluaran Gaji:
      </td>
      <td>{{number_format(($total_gpk_bonus),2, ',', '.') }}</td>
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
