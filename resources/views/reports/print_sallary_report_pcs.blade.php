<title>Laporan Gaji Karyawan</title>

<span style="font-size:15px; font-weight:bold;">Glory Laundry</span><br/>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
022-91323820, 0857 9444 0447
</address>
<div style="text-align:center;">
<span style="font-size:15px; font-weight:bold;">Laporan Gaji Karyawan</span><br/>
<span style="font-size:12px;">Periode: {{$date_start}} - {{$date_end}}</span><br/>
<span style="font-size:12px;">Nama: {{$user_name}} | PCS - {{$task}}</span><br/>
<br/>
</div>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Invoice</th>
      <th>Tgl Selesai Pengerjaan</th>
      <th>Status</th>
      <th>Layanan</th>
      <th>Kerja</th>
      <th>Qty/Satuan</th>
      <th>Jumlah</th>
    </tr>
  </thead>
  <tbody>
    <?php $subtotal = 0; $qtys =0;?>
    @foreach ($data as $key=>$data)
    <tr>
      <td>{{ $key+1 }}</td>
      <td>{{ $data->invoice_number}}</td>
      <td>{{ date('d/m/Y H:i', strtotime($data->tgl_pengerjaan)) }}</td>
      <td>{{ $data->status_trans}}/{{ $data->status }}</td>
      <td>{{ $data->package_name}}</td>
      <td>{{ $data->package_detail}}</td>
      <td>{{ $data->qty }} {{ $data->unit }}</td>
      <td>{{ number_format( $data->price, 2, ',', '.') }}</td>
    </tr>
    <?php $subtotal += $data->price;
        $qtys += $data->qty;
    ?>
    @endforeach
    <tr style="font-weight:bold">
      <td colspan="6">
        Total
      </td>
      <td>
        {{$qtys}}
      </td>
      <td>{{number_format( $subtotal, 2, ',', '.')}}</td>

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
