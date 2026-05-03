<select class="form-select" aria-label="Selectati Categoria" name="select_category">
    <option selected>Selectati Categoria</option>
    @php
        if (!function_exists('renderB2bCatOpts')) {
            function renderB2bCatOpts($cats, $parentId = '0', $prefix = '') {
                $children = $cats->where('subcat', $parentId)->sortBy('name');
                foreach ($children as $c) {
                    echo '<option value="'.$c->id.'">'.$prefix.$c->name.'</option>';
                    renderB2bCatOpts($cats, $c->id, $prefix.'— ');
                }
            }
        }
        renderB2bCatOpts($category);
    @endphp
</select>
