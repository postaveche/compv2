@extends('admin.layouts.adminlayouts')

@section('title', 'Adaugă un Banner')

@section('content')
    <div class="content-wrapper">
        <div class="container">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row ">
                        <h1>Adaugă un Banner:</h1>
                    </div>
                </div>
            </section>
            <section class="content">
                @include('admin.block.messages')
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Adăugare Banner</h3>
                    </div>
                    <form action="{{route('bannerblock.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Denumirea banner</label>
                                <input type="text" value="{{old('name')}}" class="form-control" id="Denumirea" name="name" placeholder="Denumirea banner" required>
                            </div>
                            <div class="form-group">
                                <label>Denumirea banner RU</label>
                                <input type="text" value="{{old('name_ru')}}" class="form-control" id="Denumirea" name="name_ru" placeholder="Denumirea banner RU" required>
                            </div>
                            <div class="form-group">
                                <label>Descrierea Bannerului</label>
                                <input type="text" value="{{old('description')}}" class="form-control" id="description" name="description" placeholder="Descrierea bannerului" required>
                            </div>
                            <div class="form-group">
                                <label>Descrierea bannerului RU</label>
                                <input type="text" value="{{old('description_ru')}}" class="form-control" id="description" name="description_ru" placeholder="Descrierea bannerului RU" required>
                            </div>
                            <div class="form-group">
                                <label>Linkul</label>
                                <input type="text" value="{{old('link')}}" class="form-control" id="link" name="link" placeholder="Linkul categoriei" required>
                            </div>
                            <div class="form-group">
                                <label>Imaginea</label>
                                <input class="form-control" type="file" id="uploadimg" name="uploadimg"
                                       accept=".jpg,.gif,.png" required>
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
