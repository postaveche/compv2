@extends('admin.layouts.adminlayouts')

@section('title', 'Adaugă Slider')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12"><h1>Adaugă Slider Nou</h1></div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.block.messages')
                <div class="card card-primary">
                    <form action="{{ route('sliders.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nume slider</label>
                                <input type="text" name="name" class="form-control" required placeholder="Ex: Slider pagina principală">
                            </div>
                            <div class="form-group">
                                <label>Poziție</label>
                                <select name="position" id="position-select" class="form-control" required>
                                    <option value="home">Pagina principală</option>
                                    <option value="product">Pagina produs</option>
                                    <option value="category">Categorie</option>
                                </select>
                            </div>
                            <div class="form-group" id="category-wrapper" style="display:none;">
                                <label>Categorii (lasă gol pentru toate categoriile)</label>
                                <select name="category_ids[]" class="form-control" multiple size="8">
                                    @foreach($categories as $cat)
                                        @if($cat['subcat'] == '0')
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                            @foreach($categories as $subcat)
                                                @if($subcat['subcat'] == $cat->id)
                                                    <option value="{{ $subcat->id }}"> — {{ $subcat->name }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                                <small class="text-muted">Ține Ctrl pentru a selecta mai multe categorii</small>
                            </div>
                            <div class="form-group">
                                <label>Ordine sortare</label>
                                <input type="number" name="sort_order" class="form-control" value="0">
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="active" name="active" value="1" checked>
                                    <label class="custom-control-label" for="active">Activ</label>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Salvează</button>
                            <a href="{{ route('sliders.index') }}" class="btn btn-secondary">Anulează</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('position-select').addEventListener('change', function() {
            document.getElementById('category-wrapper').style.display = this.value === 'category' ? 'block' : 'none';
        });
    </script>
@endsection
