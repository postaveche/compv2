<select class="form-select form-select" aria-label="Selectati Categoria" name="select_category">
    <option selected>Selectati Categoria</option>
    @foreach($category as $cat)
        @if($cat->subcat == 0)
    <option value="{{$cat['id']}}">{{$cat['name']}}</option>
            @foreach($category as $subcategory)
                @if($subcategory->subcat == $cat->id)
                    <option value="{{$subcategory['id']}}">- {{$subcategory['name']}}</option>
                @endif
            @endforeach
        @endif
    @endforeach
</select>
