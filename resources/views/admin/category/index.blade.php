@extends('admin.layouts.adminlayouts')

@section('title', 'Categorii')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Categoriile de produse:</h1>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="container">
        <section class="content">
            @include('admin.block.messages')
            <p><a class="btn btn-info btn-sm" href="{{ route('category.create') }}"><i class="nav-icon fas fa-edit"></i> <b>Add Category</b></a></p>
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
                        @foreach($category as $cat)
                            <tr>
                                <td>
                                    {{ $cat['id'] }}
                                </td>
                                <td>
                                    <a>
                                        <b>{{ $cat['name'] }}</b>
                                    </a>
                                    <br>
                                    <small>
                                        {{$cat->maincategory->name??null}}
                                    </small>
                                </td>
                                <td class="project_progress">
                                    {{$cat['']}}
                                </td>
                                <td class="project-state">
                                    @if ($cat['id'] == '1')
                                        <span class="badge badge-success">Activat</span>
                                    @elseif($cat['id'] == '0')
                                        <span class="badge badge-danger">Dezactivat</span>
                                    @endif
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="/admincp/import/{{$cat['b2b_code']}}/{{$cat['id']}}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Import B2B
                                    </a>
                                    <a class="btn btn-info btn-sm" href="{{ route('category.edit', $cat['id']) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <form action="{{ route('category.destroy', $cat['id']) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button></form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="d-flex justify-content-center" style="padding-top: 10px;">
                {{ $category->links("pagination::bootstrap-4") }}
            </div>
        </section>
        </div>
    </div>
@endsection
