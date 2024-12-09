@extends('admin.layouts.adminlayouts')

@section('title', 'Categorii Accent')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Categoriile B2B Accent:</h1>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            @include('admin.block.messages')
            @if(isset($allcategory_reply))
            <div class="card">
                <div class="card-body p-0">
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 10%">
                                Cod
                            </th>
                            <th style="width: 55%">
                                Denumirea
                            </th>
                            <th style="width: 5%">
                                Subcategorie
                            </th>
                            <th style="width: 5%" class="text-center">
                                Status
                            </th>
                            <th style="width: 25%">
                            </th>
                        </tr>
                        </thead>
                        @foreach($allcategory_reply as $category)
                            <tr>
                                @if($category->parentcode == null)
                                    <td>
                                        <b>{{ $category->code }}</b>
                                    </td>
                                    <td>
                                        <b>{{ $category->hardname }}</b>
                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                            </tr>
                            @foreach($allcategory_reply as $subcategory)
                                @if($category->code == $subcategory->parentcode and $subcategory->treelevel == 1)
                                    <tr>
                                        <td>
                                            | {{ $subcategory->code }}
                                        </td>
                                        <td>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-arrow-return-right"
                                                 viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
                                            </svg> {{ $subcategory->hardname }}
                                        </td>
                                        <td>

                                        </td>
                                        <td>

                                        </td>
                                        <td>
                                            <form action="{{route('import_by_folder')}}" method="GET" style="display: inline-block;">
                                                {{App\Http\Controllers\CategoryController::show_all()}}
                                                <input type="hidden" id="code" name="code" value="{{$subcategory->code}}">
                                                <input type="hidden" id="guid" name="guid" value="{{$guid}}">
                                                <button type="submit" class="btn btn-info btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-arrow-down-short"
                                                         viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                                                    </svg>
                                                    Import
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @foreach($allcategory_reply as $subcategory_2)
                                        @if($subcategory->code == $subcategory_2->parentcode and $subcategory_2->treelevel == 2)
                                            <tr>
                                                <td>
                                                    || {{ $subcategory_2->code }}
                                                </td>
                                                <td style="padding-left: 50px;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-arrow-return-right"
                                                         viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z"/>
                                                    </svg> {{ $subcategory_2->hardname }}
                                                </td>
                                                <td>

                                                </td>
                                                <td>

                                                </td>
                                                <td>
                                                    <form action="{{route('import_by_folder')}}" method="GET" style="display: inline-block;">
                                                        {{App\Http\Controllers\CategoryController::show_all()}}
                                                        <input type="hidden" id="code" name="code" value="{{$subcategory_2->code}}">
                                                        <input type="hidden" id="guid" name="guid" value="{{$guid}}">
                                                        <button type="submit" class="btn btn-info btn-sm">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                 height="16" fill="currentColor"
                                                                 class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                                                <path fill-rule="evenodd"
                                                                      d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                                                            </svg>
                                                            Import
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @foreach($allcategory_reply as $subcategory_3)
                                                @if($subcategory_2->code == $subcategory_3->parentcode and $subcategory_3->treelevel == 3)
                                                    <tr>
                                                        <td>
                                                            ||| {{ $subcategory_3->code }}
                                                        </td>
                                                        <td style="padding-left: 100px;">
                                                            ---- {{ $subcategory_3->hardname }}
                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>

                                                        </td>
                                                        <td>
                                                            <form action="{{route('import_by_folder')}}" method="GET" style="display: inline-block;">
                                                                {{App\Http\Controllers\CategoryController::show_all()}}
                                                                <input type="hidden" id="code" name="code" value="{{$subcategory_3->code}}">
                                                                <input type="hidden" id="guid" name="guid" value="{{$guid}}">
                                                                <button type="submit" class="btn btn-info btn-sm">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                         height="16" fill="currentColor"
                                                                         class="bi bi-arrow-down-short" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd"
                                                                              d="M8 4a.5.5 0 0 1 .5.5v5.793l2.146-2.147a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L7.5 10.293V4.5A.5.5 0 0 1 8 4z"/>
                                                                    </svg>
                                                                    Import
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            @endif
                        @endforeach
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <h2> <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-ethernet" viewBox="0 0 16 16">
                    <path d="M14 13.5v-7a.5.5 0 0 0-.5-.5H12V4.5a.5.5 0 0 0-.5-.5h-1v-.5A.5.5 0 0 0 10 3H6a.5.5 0 0 0-.5.5V4h-1a.5.5 0 0 0-.5.5V6H2.5a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .5.5h11a.5.5 0 0 0 .5-.5ZM3.75 11h.5a.25.25 0 0 1 .25.25v1.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25v-1.5a.25.25 0 0 1 .25-.25Zm2 0h.5a.25.25 0 0 1 .25.25v1.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25v-1.5a.25.25 0 0 1 .25-.25Zm1.75.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v1.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25v-1.5ZM9.75 11h.5a.25.25 0 0 1 .25.25v1.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25v-1.5a.25.25 0 0 1 .25-.25Zm1.75.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v1.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25v-1.5Z"/>
                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2ZM1 2a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2Z"/>
                </svg> Nu au fost primite date de la serverul API</h2>
            @endif
        </section>
    </div>
@endsection
