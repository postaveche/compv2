@extends('admin.layouts.adminlayouts')

@section('title', 'Adaugă o categorie')

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
                    <h3 class="card-title">Adăugare categorie</h3>
                </div>
                <form action="{{route('category.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label>Denumirea categoriei</label>
                            <input type="text" value="" class="form-control" id="Denumirea" name="name" placeholder="Denumirea categoriei" required>
                        </div>
                        <div class="form-group">
                            <label>Linkul</label>
                            <input type="text" value="" class="form-control" id="slug" name="slug" placeholder="Linkul categoriei" required>
                        </div>
                        <div class="form-group">
                            <label>Descrierea categoriei</label>
                            <input type="text" value="" class="form-control" id="description" name="description" placeholder="Descrierea categoriei" required>
                        </div>
                        <div class="form-group">
                            <label>Cuvinte cheie</label>
                            <input type="text" value="" class="form-control" id="keywords" name="keywords" placeholder="Cuvinte cheie" required>
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
@endsection
