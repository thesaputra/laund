<title>Slip Gaji - {{$named->name}} </title>
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
	<td>Tanggal</td>
	<td>:{{ date('d/m/Y', strtotime($named->payroll_date))}}</td>
</tr>
<tr>
	<td>Nama</td>
	<td>:{{$named->name}}</td>
</tr>
<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<?php $total = 0; ?>
	@foreach ($data as $key=>$data)

	<tr>
		<td>Pekerjaan</td>
		<td>:{{$data->desc_payroll}}</td>
	</tr>
	<tr>
		<td>Jenis</td>
		<td>:{{$data->jenis_satuan}}</td>
	</tr>
	<tr>
		<td>Qty</td>
		<td>:{{$data->qty}}&nbsp; {{$data->satuan}}</td>
	</tr>

	<tr>
		<td>Upah</td>
		<td>:{{number_format($data->amount)}}</td>
	</tr>
	<tr>
	<td colspan="2">&nbsp;</td>
</tr>
<?php $total += $data->amount; ?>
		@endforeach
		<tr>
			<td>
	<span>Total</span>
	</td>
	<td>:{{number_format($total)}}</td>
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