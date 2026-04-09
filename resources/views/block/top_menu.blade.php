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
                @php
                    $subs = $subcategory->where('subcat', $cat['id']);
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button"
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <strong>@if(session('locale') == 'ru'){{$cat['name_ru']}}@else{{$cat['name']}}@endif</strong>
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($subs as $subc)
                        @php
                            $subsubs = $subcategory->where('subcat', $subc['id']);
                        @endphp
                        @if($subsubs->count() > 0)
                        <li class="dropdown-submenu">
                            <a class="dropdown-item dropdown-toggle-sub" href="{{route('locale.all_category', session('locale'))}}/{{$subc['slug']}}">
                                @if(session('locale') == 'ru'){{$subc['name_ru']}}@else{{$subc['name']}}@endif
                            </a>
                            <ul class="dropdown-menu dropdown-submenu-menu">
                                @foreach($subsubs as $subsub)
                                <li><a class="dropdown-item" href="{{route('locale.all_category', session('locale'))}}/{{$subsub['slug']}}">
                                    @if(session('locale') == 'ru'){{$subsub['name_ru']}}@else{{$subsub['name']}}@endif
                                </a></li>
                                @endforeach
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{route('locale.all_category', session('locale'))}}/{{$subc['slug']}}"><small>@lang('main.all_cat')</small></a></li>
                            </ul>
                        </li>
                        @else
                        <li><a class="dropdown-item" href="{{route('locale.all_category', session('locale'))}}/{{$subc['slug']}}">
                            @if(session('locale') == 'ru'){{$subc['name_ru']}}@else{{$subc['name']}}@endif
                        </a></li>
                        @endif
                        @endforeach
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{route('locale.all_category', session('locale'))}}/{{$cat['slug']}}">@lang('main.all_cat')</a></li>
                    </ul>
                </li>
                @endforeach
            </ul>
            <form class="d-flex" action="{{ route('locale.search', session('locale')) }}" method="GET">
                <input class="form-control me-2" type="search" placeholder="@lang('main.search')" aria-label="@lang('main.search')" name="search" value="{{old('search')}}" required>
                <button class="btn btn-outline-success" type="submit">@lang('main.search')</button>
            </form>
        </div>
    </div>
</nav>

<style>
.dropdown-submenu { position: relative; }
.dropdown-submenu .dropdown-submenu-menu {
    display: none;
    position: absolute;
    left: 100%;
    top: 0;
    min-width: 200px;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
}
.dropdown-submenu:hover > .dropdown-submenu-menu { display: block; }
.dropdown-toggle-sub::after {
    content: "▸";
    float: right;
    margin-left: 10px;
}
/* Mobile: submeniu inline */
@media (max-width: 991px) {
    .dropdown-submenu .dropdown-submenu-menu {
        position: static;
        box-shadow: none;
        padding-left: 15px;
        border-left: 2px solid #ddd;
    }
    .dropdown-submenu:hover > .dropdown-submenu-menu { display: block; }
}
</style>
