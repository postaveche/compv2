<select class="form-control" name="subcat" required>
    <option value="0" {{ ($selected ?? 0) == '0' ? 'selected' : '' }}>Categorie principala (fara parinte)</option>
    @php
        function renderCategoryOptions($categories, $parentId = '0', $prefix = '', $selected = 0) {
            $items = $categories->where('subcat', $parentId)->sortBy('name');
            foreach ($items as $cat) {
                $sel = ($selected == $cat->id) ? 'selected' : '';
                echo "<option value=\"{$cat->id}\" {$sel}>{$prefix}{$cat->name}</option>";
                renderCategoryOptions($categories, $cat->id, $prefix . '— ', $selected);
            }
        }
        renderCategoryOptions($categories, '0', '', $selected ?? 0);
    @endphp
</select>
