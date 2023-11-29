@extends('admin.layouts.adminlayouts')

@section('title', 'Editare categorie ')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row ">
                <h1>Editare categorie: ( ID:{{$cat['id']}} - {{$cat['name']}})</h1>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        @include('admin.block.messages')
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Adăugare categorie</h3>
            </div>
            <form action="{{route('category.update', $cat['id'])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label>Denumirea categoriei</label>
                        <input type="text" value="{{$cat['name']}}" class="form-control" id="Denumirea" name="name" placeholder="Denumirea categoriei" required>
                    </div>
                    <div class="form-group">
                        <label>Denumirea categoriei RU</label>
                        <input type="text" value="{{$cat['name_ru']}}" class="form-control" id="Denumirea" name="name_ru" placeholder="Denumirea categoriei RU" required>
                    </div>
                    <div class="form-group">
                        <label>Linkul</label>
                        <input type="text" value="{{$cat['slug']}}" class="form-control" id="slug" name="slug" placeholder="Linkul categoriei" required>
                    </div>
                    <div class="form-group">
                        <label>Descrierea categoriei</label>
                        <input type="text" value="{{$cat['description']}}" class="form-control" id="description" name="description" placeholder="Descrierea categoriei" required>
                    </div>
                    <div class="form-group">
                        <label>Descrierea categoriei RU</label>
                        <input type="text" value="{{$cat['description_ru']}}" class="form-control" id="description" name="description_ru" placeholder="Descrierea categoriei RU" required>
                    </div>
                    <div class="form-group">
                        <label>Cuvinte cheie</label>
                        <input type="text" value="{{$cat['keywords']}}" class="form-control" id="keywords" name="keywords" placeholder="Cuvinte cheie" required>
                    </div>
                    <div class="form-group">
                        <label>Cuvinte cheie</label>
                        <input type="text" value="{{$cat['keywords_ru']}}" class="form-control" id="keywords" name="keywords_ru" placeholder="Cuvinte cheie RU" required>
                    </div>
                    <div class="form-group">
                        <label>Subcategorie</label>
                        <input type="text" value="{{$cat['subcat']}}" class="form-control" id="saubcategorie" name="subcat" placeholder="Subcategorie" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Editează</button>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
