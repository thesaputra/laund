<title>Slip Gaji - {{$data->name}} - {{$data->payroll_date}}</title>
<span style="font-weight:bold">Glory Laundry</span>
<address>
Lobby Kolam Renang, Tower B.No B2<br>
Apartement Jarrdin Cihampelas<br>
Hp: 0857 9444 0447
</address>
<span>---------------------------------------------------</span><br/>
<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u><strong>Slip Gaji Pegawai</strong></u></span>
<br/>
<br/>

<table>
<tr>
	<td width="70">Tanggal</td>
	<td>:{{ date('d/m/Y', strtotime($data->payroll_date))}}</td>
</tr>
<tr>
	<td width="70">Keterangan</td>
	<td>:{{$data->description}}</td>
</tr>
<tr>
	<td width="70">Nama</td>
	<td>:{{$data->name}}</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>
<tr>
	<td>Gaji Tag</td>
	<td>:{{number_format($data->gpk_tag, 2, ',', '.')}}</td>
</tr>
<tr>
	<td>Gaji Cuci</td>
	<td>:{{number_format($data->gpk_cuci, 2, ',', '.')}}</td>
</tr>
<tr>
	<td>Gaji Setrika</td>
	<td>:{{number_format($data->gpk_setrika, 2, ',', '.')}}</td>
</tr>
<tr>
	<td>Gaji Packing</td>
	<td>:{{number_format($data->gpk_packing, 2, ',', '.')}}</td>
</tr>
<tr>
	<td>Gaji QC</td>
	<td>:{{number_format($data->gpk_qc, 2, ',', '.')}}</td>
</tr>
<tr>
	<td>Bonus</td>
	<td>:{{number_format($data->bonus, 2, ',', '.')}}</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>

</tr>

<tr>
	<td>Total</td>
	<td>:{{number_format($data->gpk_tag+$data->gpk_cuci+$data->gpk_setrika+$data->gpk_packing+$data->gpk_qc+$data->bonus, 2, ',', '.')}}</td>
</tr>

</table>

<span>---------------------------------------------------</span><br/>
<span style="font-size:12px;">Pimpinan Glory Laundry</span><br/><br/>
<span>_______________</span>


<style>
*{margin:0;padding:0}
body {
  top: 0px;
}
address {
  display: block;
  font-style: normal;
  font-size: 11px;
}
</style>