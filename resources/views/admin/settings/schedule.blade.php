@extends('admin.layouts.adminlayouts')
@section('title', 'Program de lucru')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Program de lucru</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Setari zile si ore</h3></div>
<form action="{{ route('admin.schedule.update') }}" method="POST">@csrf @method('PUT')
<div class="card-body">
<table class="table">
<thead><tr><th>Ziua</th><th>Lucratoare</th><th>Deschidere</th><th>Inchidere</th><th>Status acum</th></tr></thead>
<tbody>
@foreach($schedule as $day)
<tr>
<td><strong>{{ $day->day_name }}</strong></td>
<td><input type="checkbox" name="days[{{ $day->id }}][is_working]" value="1" {{ $day->is_working ? 'checked' : '' }}></td>
<td><input type="time" name="days[{{ $day->id }}][open_time]" class="form-control form-control-sm" value="{{ $day->open_time }}" style="width:130px;"></td>
<td><input type="time" name="days[{{ $day->id }}][close_time]" class="form-control form-control-sm" value="{{ $day->close_time }}" style="width:130px;"></td>
<td>
@php
    $now = now()->timezone('Europe/Chisinau');
    $isToday = ($now->dayOfWeekIso - 1) == $day->day_of_week;
@endphp
@if($isToday)
    @if(\App\Models\WorkSchedule::isOnlineNow())
        <span class="badge badge-success">Online acum</span>
    @else
        <span class="badge badge-danger">Offline</span>
    @endif
@else
    <span class="text-muted">-</span>
@endif
</td>
</tr>
@endforeach
</tbody></table>
</div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Salveaza</button></div>
</form></div>
</div></section></div>
@endsection
