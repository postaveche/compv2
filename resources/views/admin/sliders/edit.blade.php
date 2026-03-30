@extends('admin.layouts.adminlayouts')
@section('title', 'Editare Slider')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Editare: {{ $slider->name }}</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')

<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Setari slider</h3></div>
<form action="{{ route('sliders.update', $slider->id) }}" method="POST">@csrf @method('PUT')
<div class="card-body"><div class="row">
<div class="col-md-4"><label>Nume</label><input type="text" name="name" class="form-control" value="{{ $slider->name }}" required></div>
<div class="col-md-3"><label>Pozitie</label><select name="position" id="ps" class="form-control">
<option value="home" {{ $slider->position=='home'?'selected':'' }}>Home</option>
<option value="product" {{ $slider->position=='product'?'selected':'' }}>Produs</option>
<option value="category" {{ $slider->position=='category'?'selected':'' }}>Categorie</option>
</select></div>
<div class="col-md-2"><label>Ordine</label><input type="number" name="sort_order" class="form-control" value="{{ $slider->sort_order }}"></div>
<div class="col-md-3"><label>Activ</label><div><input type="checkbox" name="active" value="1" {{ $slider->active?'checked':'' }}> Da</div></div>
</div></div>
<div class="card-footer"><button type="submit" class="btn btn-primary">Salveaza</button> <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Inapoi</a></div>
</form></div>

<div class="card card-success">
<div class="card-header"><h3 class="card-title">Adauga banner nou</h3></div>
<form action="{{ route('sliders.items.add', $slider->id) }}" method="POST" enctype="multipart/form-data">@csrf
<div class="card-body"><div class="row">
<div class="col-md-3"><label>Titlu RO</label><input type="text" name="title" class="form-control"></div>
<div class="col-md-3"><label>Titlu RU</label><input type="text" name="title_ru" class="form-control"></div>
<div class="col-md-3"><label>Link</label><input type="text" name="link" class="form-control"></div>
<div class="col-md-3"><label>Imagine *</label><input type="file" name="image" class="form-control-file" required accept="image/*"></div>
</div><div class="row mt-2">
<div class="col-md-4"><label>Descriere RO</label><input type="text" name="description" class="form-control"></div>
<div class="col-md-4"><label>Descriere RU</label><input type="text" name="description_ru" class="form-control"></div>
<div class="col-md-2"><label>Ordine</label><input type="number" name="sort_order" class="form-control" value="0"></div>
<div class="col-md-2"><label>&nbsp;</label><button type="submit" class="btn btn-success btn-block">Adauga</button></div>
</div></div></form></div>

<div class="card">
<div class="card-header"><h3 class="card-title">Bannere ({{ $slider->items->count() }})</h3></div>
<div class="card-body p-0">
@if($slider->items->count() > 0)
<table class="table table-striped">
<thead><tr><th>Imagine</th><th>Titlu</th><th>Link</th><th>Ordine</th><th>Afisari</th><th>Clickuri</th><th>CTR</th><th>Status</th><th>Actiuni</th></tr></thead>
<tbody>
@foreach($slider->items->sortBy('sort_order') as $item)
<tr>
<td><img src="{{ asset('storage/sliders/'.$item->image) }}" style="width:80px;height:50px;object-fit:cover;"></td>
<td>{{ $item->title ?? '-' }}</td>
<td><small>{{ $item->link ?? '-' }}</small></td>
<td>{{ $item->sort_order }}</td>
<td>{{ $item->views }}</td>
<td>{{ $item->clicks }}</td>
<td>{{ $item->views > 0 ? number_format(($item->clicks/$item->views)*100,1).'%' : '0%' }}</td>
<td>@if($item->active)<span class="badge badge-success">Da</span>@else<span class="badge badge-danger">Nu</span>@endif</td>
<td>
<button class="btn btn-sm btn-info" data-toggle="modal" data-target="#m{{ $item->id }}"><i class="fas fa-edit"></i></button>
<form action="{{ route('sliders.items.delete',$item->id) }}" method="POST" style="display:inline" onsubmit="return confirm('Stergi?')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button></form>
</td>
</tr>
<div class="modal fade" id="m{{ $item->id }}"><div class="modal-dialog modal-lg">
<form action="{{ route('sliders.items.update',$item->id) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
<div class="modal-content">
<div class="modal-header"><h5>Editare #{{ $item->id }}</h5><button type="button" class="close" data-dismiss="modal">&times;</button></div>
<div class="modal-body"><div class="row">
<div class="col-6"><label>Titlu RO</label><input type="text" name="title" class="form-control" value="{{ $item->title }}"></div>
<div class="col-6"><label>Titlu RU</label><input type="text" name="title_ru" class="form-control" value="{{ $item->title_ru }}"></div>
<div class="col-6 mt-2"><label>Descriere RO</label><input type="text" name="description" class="form-control" value="{{ $item->description }}"></div>
<div class="col-6 mt-2"><label>Descriere RU</label><input type="text" name="description_ru" class="form-control" value="{{ $item->description_ru }}"></div>
<div class="col-6 mt-2"><label>Link</label><input type="text" name="link" class="form-control" value="{{ $item->link }}"></div>
<div class="col-3 mt-2"><label>Ordine</label><input type="number" name="sort_order" class="form-control" value="{{ $item->sort_order }}"></div>
<div class="col-3 mt-2"><label>Activ</label><div><input type="checkbox" name="active" value="1" {{ $item->active?'checked':'' }}> Da</div></div>
<div class="col-6 mt-2"><label>Imagine noua</label><input type="file" name="image" class="form-control-file" accept="image/*"></div>
<div class="col-6 mt-2"><label>Actuala</label><br><img src="{{ asset('storage/sliders/'.$item->image) }}" style="max-height:80px"></div>
</div></div>
<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button><button type="submit" class="btn btn-primary">Salveaza</button></div>
</div></form></div></div>
@endforeach
</tbody></table>
@else
<div class="p-4 text-center text-muted"><i class="fas fa-images fa-3x mb-3"></i><p>Adauga primul banner mai sus.</p></div>
@endif
</div></div>

</div></section></div>
<script>document.getElementById('ps').addEventListener('change',function(){document.getElementById('cw').style.display=this.value==='category'?'block':'none';});</script>
@endsection
