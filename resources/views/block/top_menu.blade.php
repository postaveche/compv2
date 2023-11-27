<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @foreach($category as $cat)
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>{{$cat['name']}}</strong>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($subcategory as $subc)
                        @if($subc['subcat'] == $cat['id'])
                        <li><a class="dropdown-item" href="{{route('locale.all_category', session('locale'))}}/{{$subc['slug']}}">{{$subc['name']}}</a></li>
                        @endif
                        @endforeach
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{route('locale.all_category', session('locale'))}}/{{$cat['slug']}}">Toate</a></li>
                    </ul>
                </li>
                @endforeach
            </ul>
            <form class="d-flex" action="{{ route('locale.search', session('locale')) }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="@lang('main.search')" aria-label="@lang('main.search')" name="search" required>
                <button class="btn btn-outline-success" type="submit">@lang('main.search')</button>
            </form>
        </div>
    </div>
</nav>
