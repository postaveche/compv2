@extends('admin.layouts.adminlayouts')

@section('title', 'Gestionare Slidere')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Gestionare Slidere</h1></div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('sliders.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Adaugă Slider
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                @include('admin.block.messages')
                <div class="card">
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nume</th>
                                <th>Poziție</th>
                                <th>Bannere</th>
                                <th class="text-center">Status</th>
                                <th class="text-right">Acțiuni</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sliders as $slider)
                                <tr>
                                    <td>{{ $slider->id }}</td>
                                    <td>{{ $slider->name }}</td>
                                    <td>
                                        @if($slider->position == 'home')
                                            <span class="badge badge-primary">Pagina principală</span>
                                        @elseif($slider->position == 'product')
                                            <span class="badge badge-info">Pagina produs</span>
                                        @elseif($slider->position == 'category')
                                            <span class="badge badge-warning">Categorie</span>
                                        @endif
                                    </td>
                                    <td>{{ $slider->items_count }} bannere</td>
                                    <td class="text-center">
                                        @if($slider->active)
                                            <span class="badge badge-success">Activ</span>
                                        @else
                                            <span class="badge badge-danger">Inactiv</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('sliders.stats', $slider->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-chart-bar"></i> Statistici
                                        </a>
                                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-pencil-alt"></i> Edit
                                        </a>
                                        <form action="{{ route('sliders.destroy', $slider->id) }}" method="POST" style="display:inline-block;"
                                              onsubmit="return confirm('Ești sigur? Se vor șterge și toate bannerele din acest slider.')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Șterge</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
