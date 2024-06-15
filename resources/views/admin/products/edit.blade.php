@extends('admin.layouts.adminlayouts')

@section('title', 'Editare produs '.$produs['name'])

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Editare produs: {{$produs['name']}}</h1>
                </div>
            </div>
        </section>
        <section class="content">
    @include('admin.block.messages')
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Editare produs: {{$produs['name']}}</h3>
                </div>
                <form action="{{route('products.update', $produs['id'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label>Denumirea produsului</label>
                            <input type="text" value="{{$produs['name']}}" class="form-control" id="Denumirea" name="name"
                                   placeholder="Denumirea produsului" required>
                        </div>
                        <div class="form-group">
                            <label>Descrierea produsului</label>
                            <input type="text" value="{{$produs['description']}}" class="form-control" id="description" name="description"
                                   placeholder="Descrierea produsului" required>
                        </div>
                        <div class="form-group">
                            <label>Cuvinte cheie</label>
                            <input type="text" value="{{$produs['keywords']}}" class="form-control" id="keywords" name="keywords"
                                   placeholder="Cuvinte cheie" required>
                        </div>
                        <div class="form-group">
                            <label>Linkul</label>
                            <input type="text" value="{{$produs['slug']}}" class="form-control" id="slug" name="slug"
                                   placeholder="Linkul produsului">
                        </div>
                        <div class="form-group">
                            <label>SKU Produs (codul unic al produsului)</label>
                            <input type="text" value="{{$produs['sku']}}" class="form-control" id="sku" name="sku"
                                   placeholder="SKU Produs" required>
                        </div>
                        <div class="form-group">
                            <label>Imagini</label>
                            <input class="form-control" type="file" id="uploadimg" name="uploadimg[]"
                                   accept=".jpg,.gif,.png" multiple>
                        </div>
                        <div class="form-group">
                            <label>Example textarea</label>
                            <textarea class="form-control" id="fulldescription" name="text" rows="4">{{$produs['text']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Pretul produsului (USD)</label>
                            <input type="text" value="{{$produs['price']}}" class="form-control" id="price" name="price" placeholder="Pret"
                                   required>
                        </div>
                        <div class="form-group">
                            <label>Pret Special al produsului (USD)</label>
                            <input type="text" value="{{$produs['special_price']}}" class="form-control" id="specialprice" name="specialprice"
                                   placeholder="Pret Special al produsului">
                        </div>
                        <div class="form-group">
                            <label>Selectati categoria: </label>
                            <select class="form-select" aria-label="Selectati categoria:" name="category_id">
                                @foreach($category as $cat)
                                    @if($cat['subcat'] == '0')
                                        <option value="{{$cat['id']}}">{{$cat['name']}}</option>
                                        @foreach($category as $subcat)
                                            @if($subcat['subcat'] == $cat['id'])
                                                <option value="{{$subcat['id']}}"> - {{$subcat['name']}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="{{Auth::id()}}" />
                        <div class="form-group">
                            <label>Starea produsului: </label>
                            <select class="form-select" aria-label="Starea produsului:" name="active">
                                <option value="1">Activat</option>
                                <option value="0">Dezactivat</option>
                            </select>
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
