@extends('admin.layouts.adminlayouts')
@section('title', 'Adaugă banner')
@section('content')
<div class="content-wrapper">
 <section class="content-header"><div class="container-fluid"><div class="row mb-2"><div class="col-sm-6"><h1>Adaugă banner</h1></div><div class="col-sm-6 text-right"><a href="{{ route('bannerblock.index') }}" class="btn btn-secondary">Înapoi la listă</a></div></div></div></section>
 <section class="content"><div class="container-fluid">@include('admin.block.messages')<div class="card card-primary"><div class="card-header"><h3 class="card-title">Banner nou</h3></div><form action="{{ route('bannerblock.store') }}" method="POST" enctype="multipart/form-data">@csrf @include('admin.bannerblock.form',['submitLabel'=>'Adaugă banner','imageRequired'=>true])</form></div></div></section>
</div>
@endsection
