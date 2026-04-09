@extends('admin.layouts.adminlayouts')
@section('title', 'Categorii B2B Accent')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><div class="row mb-2">
<div class="col-sm-6"><h1>Categorii B2B Accent</h1></div>
<div class="col-sm-6 text-right">
<button class="btn btn-sm btn-outline-secondary" onclick="document.querySelectorAll('.b2b-children').forEach(e=>e.style.display='')"><i class="fas fa-expand"></i> Deschide toate</button>
<button class="btn btn-sm btn-outline-secondary" onclick="document.querySelectorAll('.b2b-children').forEach(e=>e.style.display='none')"><i class="fas fa-compress"></i> Inchide toate</button>
</div>
</div></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
@if(isset($allcategory_reply))

@php
    $items = collect($allcategory_reply);
    $mainCats = $items->whereNull('parentcode')->sortBy('hardname');
@endphp

@foreach($mainCats as $main)
<div class="card mb-2">
<div class="card-header p-2" style="cursor:pointer;background:#f4f6f9;border-bottom:1px solid #e0e0e0;" onclick="var el=document.getElementById('children-{{$main->code}}');el.style.display=el.style.display==='none'?'':'none';">
<div class="d-flex justify-content-between align-items-center">
<div>
<i class="fas fa-folder text-secondary"></i>
<strong>{{ $main->hardname }}</strong>
<small class="text-muted ml-2">[{{ $main->code }}]</small>
@php $childCount = $items->where('parentcode', $main->code)->count(); @endphp
<span class="badge badge-light border ml-1">{{ $childCount }}</span>
</div>
<i class="fas fa-chevron-down text-muted" style="font-size:0.75rem;"></i>
</div>
</div>
<div id="children-{{$main->code}}" class="b2b-children" style="display:none;">
<table class="table table-sm table-hover mb-0">
@php $level1 = $items->where('parentcode', $main->code)->sortBy('hardname'); @endphp
@foreach($level1 as $sub1)
<tr style="background:#f8f9fa;">
<td style="width:80px;padding-left:15px;"><strong>{{ $sub1->code }}</strong></td>
<td style="padding-left:15px;">
<i class="fas fa-folder-open text-info"></i> <strong>{{ $sub1->hardname }}</strong>
@php $sub1children = $items->where('parentcode', $sub1->code); @endphp
@if($sub1children->count() > 0)
<a href="#" onclick="event.preventDefault();var el=document.getElementById('sub-{{$sub1->code}}');el.style.display=el.style.display==='none'?'':'none';" class="ml-2">
<small><i class="fas fa-plus-circle"></i> {{ $sub1children->count() }} sub</small>
</a>
@endif
</td>
<td style="width:350px;">
<form action="{{route('import_by_folder')}}" method="GET" class="form-inline justify-content-end">
{{App\Http\Controllers\CategoryController::show_all()}}
<input type="hidden" name="code" value="{{$sub1->code}}">
<input type="hidden" name="guid" value="{{$guid}}">
<button type="submit" class="btn btn-info btn-sm ml-1"><i class="fas fa-download"></i> Import</button>
</form>
</td>
</tr>
@if($sub1children->count() > 0)
<tr id="sub-{{$sub1->code}}" style="display:none;">
<td colspan="3" style="padding:0;">
<table class="table table-sm mb-0">
@foreach($sub1children->sortBy('hardname') as $sub2)
<tr>
<td style="width:80px;padding-left:40px;">{{ $sub2->code }}</td>
<td style="padding-left:40px;">
<i class="fas fa-file text-muted"></i> {{ $sub2->hardname }}
@php $sub2children = $items->where('parentcode', $sub2->code); @endphp
@if($sub2children->count() > 0)
<a href="#" onclick="event.preventDefault();var el=document.getElementById('sub-{{$sub2->code}}');el.style.display=el.style.display==='none'?'':'none';" class="ml-2">
<small><i class="fas fa-plus-circle"></i> {{ $sub2children->count() }}</small>
</a>
@endif
</td>
<td style="width:350px;">
<form action="{{route('import_by_folder')}}" method="GET" class="form-inline justify-content-end">
{{App\Http\Controllers\CategoryController::show_all()}}
<input type="hidden" name="code" value="{{$sub2->code}}">
<input type="hidden" name="guid" value="{{$guid}}">
<button type="submit" class="btn btn-info btn-sm ml-1"><i class="fas fa-download"></i> Import</button>
</form>
</td>
</tr>
@if($sub2children->count() > 0)
<tr id="sub-{{$sub2->code}}" style="display:none;">
<td colspan="3" style="padding:0 0 0 60px;">
<table class="table table-sm mb-0">
@foreach($sub2children->sortBy('hardname') as $sub3)
<tr>
<td style="width:80px;">{{ $sub3->code }}</td>
<td><i class="fas fa-file-alt text-secondary"></i> {{ $sub3->hardname }}</td>
<td style="width:350px;">
<form action="{{route('import_by_folder')}}" method="GET" class="form-inline justify-content-end">
{{App\Http\Controllers\CategoryController::show_all()}}
<input type="hidden" name="code" value="{{$sub3->code}}">
<input type="hidden" name="guid" value="{{$guid}}">
<button type="submit" class="btn btn-info btn-sm ml-1"><i class="fas fa-download"></i> Import</button>
</form>
</td>
</tr>
@endforeach
</table>
</td>
</tr>
@endif
@endforeach
</table>
</td>
</tr>
@endif
@endforeach
</table>
</div>
</div>
@endforeach

@else
<div class="card"><div class="card-body text-center">
<i class="fas fa-network-wired fa-3x text-muted mb-3"></i>
<h4>Nu au fost primite date de la serverul API</h4>
</div></div>
@endif
</div></section></div>
@endsection
