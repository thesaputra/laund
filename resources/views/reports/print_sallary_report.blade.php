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
<span style="font-size:12px;">Nama: {{$user_name}} | {{$task}}</span><br/>
<br/>
</div>
<table style="font-size:12px; border: 1px solid gray; text-align:center;" width="100%">
  <thead>
    <tr>
      <th>No</th>
      <th>Invoice</th>
      <th>Info Customer</th>
      <th>Tgl Order / Selesai</th>
      <th>Tgl Selesai Pengerjaan</th>
      <th>Status</th>
      <th>Jenis Pekerjaan</th>
      <th>Qty/Satuan</th>
      <th>Harga Satuan</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>
    <?php $subtotal = 0; $qtys =0;?>
    @foreach ($data as $key=>$data)
    <tr>
      <td>{{ $key+1 }}</td>
      <td>{{ $data->invoice_number}}</td>
      <td>{{ $data->cust_name }}-{{$data->cust_address}}</td>
      <td>{{ date('d/m/Y', strtotime($data->trans_date_order)) }}-{{date('d/m/Y', strtotime($data->trans_date_deliver))}}</td>
      
      <td>{{ date('d/m/Y H:i', strtotime($data->tgl_pengerjaan)) }}</td>
      <td>{{ $data->status_trans}}/{{ $data->status }}</td>
      <td>{{ $data->package_name}}</td>
      <td>{{ $data->qty }}/{{ $data->unit }}</td>
      <td>{{ number_format( $data->price_opr, 2, ',', '.') }}</td>
      <td>{{ number_format( $data->price_opr * $data->qty, 2, ',', '.') }}</td>
    </tr>
    <?php $subtotal += $data->price_opr * $data->qty;
        $qtys += $data->qty;
    ?>
    @endforeach
    <tr style="font-weight:bold">
      <td colspan="5">
        SubTotal
      </td>
      <td>
        {{$qtys}}
      </td>
      <td></td>
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
