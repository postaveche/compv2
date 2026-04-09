@php
    $breadcrumbs = collect();
    $current = $cat;
    $breadcrumbs->prepend($current);
    while ($current->subcat != '0' && $current->parent) {
        $current = $current->parent;
        $breadcrumbs->prepend($current);
    }
    $locale = session('locale');
@endphp
<nav class="breadcrumb-nav" aria-label="breadcrumb">
    <ol class="breadcrumb-list">
        <li class="breadcrumb-item">
            <a href="{{ route('locale.acasa', $locale) }}" title="Comp.MD">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16" style="vertical-align:-2px;">
                    <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 2 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5z"/>
                </svg>
                @lang('breadcrumbs.home')
            </a>
        </li>
        @foreach($breadcrumbs as $crumb)
        <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
            @if($loop->last)
                @if($locale == 'ru'){{ $crumb->name_ru ?? $crumb->name }}@else{{ $crumb->name }}@endif
            @else
                <a href="/{{ $locale }}/category/{{ $crumb->slug }}">@if($locale == 'ru'){{ $crumb->name_ru ?? $crumb->name }}@else{{ $crumb->name }}@endif</a>
            @endif
        </li>
        @endforeach
    </ol>
</nav>

<style>
.breadcrumb-nav { margin: 0 0 5px; }
.breadcrumb-list {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
    font-size: 0.85rem;
}
.breadcrumb-item + .breadcrumb-item::before {
    content: "→";
    padding: 0 6px;
    color: #adb5bd;
}
.breadcrumb-item a {
    color: #51585e;
    text-decoration: none;
}
.breadcrumb-item a:hover { color: #0d6efd; }
.breadcrumb-item.active { color: #999; }
</style>
