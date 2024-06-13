@extends('admin.layouts.adminlayouts')

@section('title', 'Pagini statice')

@section('content')
    <div class="content-wrapper">
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
                    <h3 class="card-title">Adăugare Pagină</h3>
                </div>
                <form action="{{route('pages.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Denumirea Paginii RO</label>
                            <input type="text" value="{{old('name_ro')}}" class="form-control" id="Denumirea RO" name="name_ro" placeholder="Denumirea paginii RO" required>
                        </div>
                        <div class="form-group">
                            <label>Denumirea Paginii RU</label>
                            <input type="text" value="{{old('name_ru')}}" class="form-control" id="Denumirea RU" name="name_ru" placeholder="Denumirea paginii RU" required>
                        </div>
                        <div class="form-group">
                            <label>Linkul Paginii (slug)</label>
                            <input type="text" value="{{old('name_slug')}}" class="form-control" id="slug" name="slug" placeholder="Linkul Paginii">
                        </div>
                        <div class="form-group">
                            <label>Descrierea Paginii RO</label>
                            <input type="text" value="{{old('desc_ro')}}" class="form-control" id="description_ro" name="desc_ro" placeholder="Descrierea Paginii RO" required>
                        </div>
                        <div class="form-group">
                            <label>Descrierea paginii RU</label>
                            <input type="text" value="{{old('desc_ro')}}" class="form-control" id="description_ru" name="desc_ru" placeholder="Descrierea Paginii RU" required>
                        </div>
                        <div class="form-group">
                            <label>Continutul Paginii RO</label>
                            <textarea class="form-control" id="comp_editor" name="text_ro" rows="4"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Continutul Paginii RU</label>
                            <textarea class="form-control" id="comp_editor2" name="text_ru" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Adaugă</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
