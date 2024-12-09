@extends('admin.layouts.adminlayouts')

@section('title', 'Banner Block')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row ">
                <h1>Toate bannerele disponibile:</h1>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container">
        <section class="content">
            @include('admin.block.messages')
            <p><a class="btn btn-info btn-sm" href="{{ route('bannerblock.create') }}"><i class="nav-icon fas fa-edit"></i> <b>Add Banner</b></a></p>
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                ID
                            </th>
                            <th style="width: 59%">
                                Denumirea
                            </th>
                            <th style="width: 5%">
                                Subcategorie
                            </th>
                            <th style="width: 5%" class="text-center">
                                Status
                            </th>
                            <th style="width: 30%">
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($banners as $banner)
                            <tr>
                                <td>
                                    {{ $banner['id'] }}
                                </td>
                                <td>
                                    <a>
                                        <b>{{ $banner['name'] }}</b>
                                    </a>
                                    <br>
                                </td>
                                <td>
                                    {{ $banner['image'] }}
                                </td>
                                <td class="project-state">
                                    <a href="/{{session('locale')}}/{{ $banner['link'] }}">
                                    Link</a>
                                </td>
                                <td class="project-actions text-right">
                                    Edit
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
    </div>
</div>
@endsection
