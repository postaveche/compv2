@extends('admin.layouts.adminlayouts')

@yield('title', 'Administrare produse')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Toate produsele disponibile:</h1>
                </div>
            </div>
        </section>
        <section class="content">
            @include('admin.block.messages')
            <p><a class="btn btn-info btn-sm" href="{{ route('products.create') }}"><i class="nav-icon fas fa-edit"></i>
                    <b>Adauga Produs</b></a></p>
            <div class="admin_filtre">
                <form action="{{route('findproducts')}}" method="get">
                    <label>Cautare:</label>
                    <input type="text" name="query" required>
                    <button type="submit">Go</button>
                </form>
            </div>
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
                        @foreach($produse as $product)
                            <tr>
                                <td>
                                    {{ $product['id'] }}
                                </td>
                                <td>
                                    <a>
                                        <b>{{ $product['name'] }}</b>
                                    </a>
                                    <br>
                                    <small>
                                        {{$product->category->name}}
                                    </small>
                                </td>
                                <td class="project_progress">
                                    {{$product['']}}
                                </td>
                                <td class="project-state">
                                    @if ($product['active'] == '1')
                                        <span class="badge badge-success">Activat</span>
                                    @elseif($product['active'] == '0')
                                        <span class="badge badge-danger">Dezactivat</span>
                                    @endif
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="{{ route('products.edit', $product['id']) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product['id']) }}" method="POST"
                                          style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="d-flex justify-content-center" style="padding-top: 10px;">
                {{ $produse->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </section>
    </div>
@endsection
