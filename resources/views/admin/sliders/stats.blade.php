@extends('admin.layouts.adminlayouts')

@section('title', 'Statistici Slider: ' . $slider->name)

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6"><h1>Statistici: {{ $slider->name }}</h1></div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('sliders.edit', $slider->id) }}" class="btn btn-info">
                            <i class="fas fa-pencil-alt"></i> Editare slider
                        </a>
                        <a href="{{ route('sliders.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Înapoi
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <!-- Sumar general -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $slider->items->count() }}</h3>
                                <p>Total bannere</p>
                            </div>
                            <div class="icon"><i class="fas fa-images"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ number_format($totalViews) }}</h3>
                                <p>Total afișări</p>
                            </div>
                            <div class="icon"><i class="fas fa-eye"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ number_format($totalClicks) }}</h3>
                                <p>Total click-uri</p>
                            </div>
                            <div class="icon"><i class="fas fa-mouse-pointer"></i></div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $totalViews > 0 ? number_format(($totalClicks / $totalViews) * 100, 1) : 0 }}%</h3>
                                <p>CTR mediu</p>
                            </div>
                            <div class="icon"><i class="fas fa-percentage"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Statistici per banner -->
                <div class="card">
                    <div class="card-header"><h3 class="card-title">Statistici per banner</h3></div>
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Imagine</th>
                                <th>Titlu</th>
                                <th class="text-center">Afișări</th>
                                <th class="text-center">Click-uri</th>
                                <th class="text-center">CTR</th>
                                <th class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($slider->items->sortByDesc('views') as $item)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/sliders/' . $item->image) }}"
                                             class="img-thumbnail" style="width:80px; height:50px; object-fit:cover;">
                                    </td>
                                    <td>
                                        {{ $item->title ?? 'Fără titlu' }}
                                        @if($item->link)
                                            <br><small class="text-muted">{{ $item->link }}</small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="font-weight-bold">{{ number_format($item->views) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="font-weight-bold">{{ number_format($item->clicks) }}</span>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $ctr = $item->views > 0 ? ($item->clicks / $item->views) * 100 : 0;
                                        @endphp
                                        <span class="badge {{ $ctr > 5 ? 'badge-success' : ($ctr > 1 ? 'badge-warning' : 'badge-secondary') }}">
                                            {{ number_format($ctr, 1) }}%
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->active)
                                            <span class="badge badge-success">Activ</span>
                                        @else
                                            <span class="badge badge-danger">Inactiv</span>
                                        @endif
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
