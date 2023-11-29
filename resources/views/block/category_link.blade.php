<div class="category_link">
    <div>
        @include('block.breadcrumbs')
        <h1>@if(session('locale') == 'ru'){{$cat['name_ru']}}@else {{$cat['name']}}@endif</h1>
        <small>@if(session('locale') == 'ru'){{$cat['description_ru']}}@else {{$cat['description']}}@endif</small>
    </div>
</div>
