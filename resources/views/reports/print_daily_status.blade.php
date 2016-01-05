<title>Laporan Status Trsansaksi Harian</title>

<span style="font-size:15px; font-weight:bold;">Glory Laundry</span><br/>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
022-91323820, 0857 9444 0447
</address>
<div style="text-align:center;">
<span style="font-size:15px; font-weight:bold;">Laporan Status Transaksi Harian</span><br/>
<span style="font-size:12px;">Periode: {{$date_start}} - {{$date_end}}</span><br/>
<br/>
</div>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead><?php
  $total_sudah_bayar = 0;
  $total_pcs = 0;
  $total_kg = 0;
  $total_mtr = 0;
  ?>
      <tr>
        <th>No</th>
        <th>Invoice</th>
        <th>Nama/Alamat</th>
        <th>Tgl Order</th>
        <th>KG</th>
        <th>Mtr</th>
        <th>PCS</th>
        <th>Sudah Bayar</th>
        <th>Sisa Bayar</th>
      </tr>
        </thead>
        <tbody>
      @foreach ($data as $key=>$data)
      <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $data->trans_invoice}}</td>
        <td>{{ $data->cust_name.' / '.$data->cust_address}}</td>
        <td>{{ date('d/m/Y', strtotime($data->trans_date_order)) }}</td>
        <td>{{ ($data->jml_kg == '') ? '0':$data->jml_kg }}</td>
        <td>{{ ($data->jml_mtr == '') ? '0':$data->jml_mtr }}</td>
        <td>{{ ($data->jml_pcs == '') ? '0':$data->jml_pcs }}</td>
        <td>{{ number_format( $data->sudah_bayar, 2, ',', '.') }}</td>
        <td>{{ number_format( $data->sudah_bayar, 2, ',', '.') }}</td>
      </tr>
      <?php
      $total_sudah_bayar += $data->sudah_bayar;
      $total_kg += $data->jml_kg;
      $total_mtr += $data->jml_mtr;
      $total_pcs += $data->jml_pcs;


      ?>
      @endforeach
    </tbody>
    <tr style="font-weight:bold">
      <td colspan="4" align="right">
        Total:
      </td>
      <td>{{$total_kg}}</td>
      <td>{{$total_mtr}}</td>
      <td>{{$total_pcs}}</td>
      <td>{{ number_format( $total_sudah_bayar, 2, ',', '.') }}</td>
      <td>{{ number_format( $total_sudah_bayar, 2, ',', '.') }}</td>
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
