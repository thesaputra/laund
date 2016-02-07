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

<span style="margin-right:19px;">Tanggal</span><span>:{{$data->payroll_date}}</span><br/>
<span style="margin-right:43px;">Ket.</span><span>:{{$data->description}}</span><br/><br/>
<span style="margin-right:33px;">Nama</span><span>:{{$data->name}}</span><br/>
<span style="margin-right:43px;">Gaji</span><span>:Rp.{{number_format($data->gpk, 2, ',', '.')}}</span><br/>
<span style="margin-right:30px;">Bonus</span><span>:Rp.{{number_format($data->bonus, 2, ',', '.')}}</span><br/>
<span style="margin-right:37px;">Total</span><span>:Rp.{{number_format($data->gpk+$data->bonus, 2, ',', '.')}}</span><br/>

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