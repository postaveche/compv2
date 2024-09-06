@extends('admin.layouts.adminlayouts')

@section('title', 'Adaugă o categorie')

@section('content')
    <div class="content-wrapper">
        <div class="container">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Adaugă o categorie:</h1>
                </div>
            </div>
        </section>
        <section class="content">
            @include('admin.block.messages')
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Adăugare categorie</h3>
                </div>
                <form action="{{route('category.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Denumirea categoriei</label>
                            <input type="text" value="{{old('name')}}" class="form-control" id="Denumirea" name="name" placeholder="Denumirea categoriei" required>
                        </div>
                        <div class="form-group">
                            <label>Denumirea categoriei RU</label>
                            <input type="text" value="{{old('name_ru')}}" class="form-control" id="Denumirea" name="name_ru" placeholder="Denumirea categoriei RU" required>
                        </div>
                        <div class="form-group">
                            <label>Linkul</label>
                            <input type="text" value="{{old('slug')}}" class="form-control" id="slug" name="slug" placeholder="Linkul categoriei" required>
                        </div>
                        <div class="form-group">
                            <label>Titlul Categoriei RO</label>
                            <input type="text" value="{{old('title_ro')}}" class="form-control" id="title_ro" name="title_ro" placeholder="Titlul Categoriei RO">
                        </div>
                        <div class="form-group">
                            <label>Titlul Categoriei RU</label>
                            <input type="text" value="{{old('title_ru')}}" class="form-control" id="title_ru" name="title_ru" placeholder="Titlul Categoriei RU">
                        </div>
                        <div class="form-group">
                            <label>Descrierea categoriei</label>
                            <input type="text" value="{{old('description')}}" class="form-control" id="description" name="description" placeholder="Descrierea categoriei" required>
                        </div>
                        <div class="form-group">
                            <label>Descrierea categoriei RU</label>
                            <input type="text" value="{{old('description_ru')}}" class="form-control" id="description" name="description_ru" placeholder="Descrierea categoriei RU" required>
                        </div>
                        <div class="form-group">
                            <label>Cuvinte cheie</label>
                            <input type="text" value="{{old('keywords')}}" class="form-control" id="keywords" name="keywords" placeholder="Cuvinte cheie" required>
                        </div>
                        <div class="form-group">
                            <label>Cuvinte cheie RU</label>
                            <input type="text" value="{{old('keywords_ru')}}" class="form-control" id="keywords" name="keywords_ru" placeholder="Cuvinte cheie RU" required>
                        </div>
                    <div>
                        <label>Descrierea complecta RO</label>
                        <textarea class="form-control" name="full_desc_ro" id="compeditor" cols="30" rows="10">
                            {!!old('full_desc_ro')!!}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Descrierea complecta RU</label>
                        <textarea class="form-control" name="full_desc_ru" id="compeditor">
                            {{old('full_desc_ru')}}
                        </textarea>
                    </div>
                        <div class="form-group">
                            <label>Subcategorie</label>
                            <input type="text" value="" class="form-control" id="saubcategorie" name="subcat" placeholder="Subcategorie" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Adaugă</button>
                    </div>
                </form>
            </div>
        </section>
        </div>
    </div>
@endsection
