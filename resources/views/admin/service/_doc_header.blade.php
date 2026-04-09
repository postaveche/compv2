<table style="width:100%;border:none;margin-bottom:10px;border-bottom:2px solid #333;padding-bottom:10px;">
<tr style="border:none;">
<td style="border:none;width:30%;vertical-align:middle;">
@if($isPdf ?? false)
@php $logoPath = public_path('logo.png'); $logoData = file_exists($logoPath) ? base64_encode(file_get_contents($logoPath)) : ''; @endphp
@if($logoData)<img src="data:image/png;base64,{{ $logoData }}" style="height: 45px;">@endif
@else
<img src="{{ asset('logo.png') }}" alt="Comp.MD" style="height: 50px;">
@endif
</td>
<td style="border:none;text-align:right;font-size:11px;color:#555;vertical-align:middle;">
IT Service Grup S.R.L.<br>
str. Sarmizegetusa 51, et. 1, of. 130<br>
mun. Chisinau, Republica Moldova<br>
Tel: 060 229-129, 078 37-37-36, 067 711-444
</td>
</tr>
</table>
