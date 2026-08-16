@extends('admin.layouts.adminlayouts')
@section('title', 'Editează banner')
@section('content')
<div class="content-wrapper">
 <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Editează bannerul #{{ $banner->id }}</h1></div><div class="col-sm-6 text-right"><a href="{{ route('bannerblock.index') }}" class="btn btn-secondary">Înapoi la listă</a></div></div></div></section>
 <section class="content"><div class="container-fluid">@include('admin.block.messages')<div class="card card-info"><div class="card-header"><h3 class="card-title">{{ $banner->name }}</h3></div><form action="{{ route('bannerblock.update',$banner->id) }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.bannerblock.form',['submitLabel'=>'Salvează modificările','imageRequired'=>false])</form></div></div></section>
</div>
@endsection
