<div class="filter_block mb-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i> Filtre de căutare
                @php
                    $hasFilters = request()->hasAny(['query', 'category_id', 'status', 'price_min', 'price_max', 'sort_by']);
                @endphp
                @if($hasFilters)
                    <span class="badge badge-info ml-2">Filtre active</span>
                @endif
            </h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('findproducts')}}" method="get" id="filter-form">
                <div class="row">
                    <!-- Căutare text -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Căutare (Nume/SKU/Text):</label>
                            <input type="text" name="query" class="form-control" 
                                   placeholder="Caută produs..." 
                                   value="{{ request('query') }}">
                        </div>
                    </div>
                    
                    <!-- Categorie -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Categorie:</label>
                            <select name="category_id" class="form-control">
                                <option value="">Toate categoriile</option>
                                @php
                                    $filterCats = \App\Models\Category::orderBy('name')->get();
                                    if (!function_exists('renderFilterCatOpts')) {
                                        function renderFilterCatOpts($cats, $parentId = '0', $prefix = '', $selectedId = null) {
                                            $children = $cats->where('subcat', $parentId)->sortBy('name');
                                            foreach ($children as $c) {
                                                $sel = ($selectedId == $c->id) ? 'selected' : '';
                                                echo "<option value=\"{$c->id}\" {$sel}>{$prefix}{$c->name}</option>";
                                                renderFilterCatOpts($cats, $c->id, $prefix.'— ', $selectedId);
                                            }
                                        }
                                    }
                                    renderFilterCatOpts($filterCats, '0', '', request('category_id'));
                                @endphp
                            </select>
                        </div>
                    </div>
                    
                    <!-- Status -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Status:</label>
                            <select name="status" class="form-control">
                                <option value="">Toate</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Activat</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Dezactivat</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Preț minim -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Preț min ($):</label>
                            <input type="number" name="price_min" class="form-control" 
                                   placeholder="0" 
                                   value="{{ request('price_min') }}">
                        </div>
                    </div>
                    
                    <!-- Preț maxim -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Preț max ($):</label>
                            <input type="number" name="price_max" class="form-control" 
                                   placeholder="9999" 
                                   value="{{ request('price_max') }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Sortare -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Sortare după:</label>
                            <select name="sort_by" class="form-control">
                                <option value="id" {{ request('sort_by') == 'id' ? 'selected' : '' }}>ID</option>
                                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nume</option>
                                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Preț</option>
                                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Data creării</option>
                                <option value="updated_at" {{ request('sort_by') == 'updated_at' ? 'selected' : '' }}>Data actualizării</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Ordine sortare -->
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Ordine:</label>
                            <select name="sort_order" class="form-control">
                                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descrescător</option>
                                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Crescător</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Butoane -->
                    <div class="col-md-7">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Caută
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Resetează
                                </a>
                                @if($hasFilters)
                                    <span class="ml-2 text-muted">
                                        <i class="fas fa-info-circle"></i> 
                                        Afișare rezultate filtrate
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
