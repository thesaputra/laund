<title>{{$invoice}}</title>
<span style="font-weight:bold">Glory Laundry</span>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
Hp: 0857 9444 0447
</address>
<span>----------------------------------------------------------</span>
<br/>
<span>Rincian Pakaian</span><br/>
<span style="font-size:12px">No.{{$invoice}}</span><br/><span style="font-size:12px">Order: {{ date('d-m-Y', strtotime($data['transaction']->date_order))}}</span> ---
<span style="font-size:12px">Selesai: {{ date('d-m-Y', strtotime($data['transaction']->date_deliver))}}</span><br/>
<span style="font-size:12px">Nama: {{strtoupper($data['transaction']->name.' / '.$data['transaction']->address)}}</span><br/>
<br/>
<table style="font-size:12px" width="36%">
<thead>
<tr>
  <th align="left">Items</th>
  <th>Keterangan</th>
  <th>Jumlah</th>
</tr>
</thead>
<tbody>
<?php $subtotal = 0; ?>
  @foreach($data['item_transaction'] as $key => $value)
	<tr>
    <td>{{ $value->item_name }}</td>
    <td align="center">{{ $value->description}}</td>
    <td align="center">{{ $value->qty}}</td>
  </tr>
  <?php $subtotal += $value->qty; ?>
  @endforeach
  <tr style="text-align:right;">
    <td colspan="2">Total: </td>
    <td style="text-align:center;"><?=$subtotal;?></td>
  </tr>
</tbody>
</table>

<span>----------------------------------------------------------</span><br/>
<span style="font-size:18px; font-weight:bold">Terima kasih!</span><br/>
<span style="font-size:12px">Ketentuan:</span><br/>
<span style="font-size:10px width:100px; display:block">Maksimal pengambilan barang dilakukan 1 bulan dari tgl
  <br/>selesai, jika pengambilan dilakukan lebih dari 1 bulan
  <br/>maka barang Anda diluar dari tanggung jawab kami.
</span>
<br/>
<span style="font-size:10px">Glory Laundry - Laundry Management<span>
<style>
*{margin:0;padding:0}
address {
  display: block;
  font-style: normal;
  font-size: 11px;
}
</style>
