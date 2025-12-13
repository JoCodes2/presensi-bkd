@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Badan kepegawaian Daerah Provinsi Sulawesi Tengah')
<img src="{{ asset('logo.png') }}" class="logo" alt="Logo">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
