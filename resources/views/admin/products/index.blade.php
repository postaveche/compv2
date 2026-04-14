@extends('admin.layouts.adminlayouts')

@yield('title', 'Administrare produse')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1>Toate produsele disponibile</h1>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @include('admin.block.filter')
                
                @include('admin.block.messages')
                
                <p><a class="btn btn-info btn-sm" href="{{ route('products.create') }}">
                    <i class="nav-icon fas fa-edit"></i>
                    <b>Adauga Produs</b>
                </a></p>

            <!-- Controale pentru acțiuni în masă -->
            <div class="card mb-3">
                <div class="card-body">
                    <form id="bulk-action-form" action="{{ route('products.bulk-update') }}" method="POST">
                        @csrf
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Acțiuni în masă:</label>
                                <select name="bulk_action" id="bulk-action-select" class="form-control" required>
                                    <option value="">Selectează acțiunea</option>
                                    <option value="activate">Activează produsele</option>
                                    <option value="deactivate">Dezactivează produsele</option>
                                    <option value="change_category">Schimbă categoria</option>
                                </select>
                            </div>
                            <div class="col-md-3" id="category-select-wrapper" style="display: none;">
                                <label class="form-label">Selectează categoria:</label>
                                <select name="category_id" id="category-select" class="form-control">
                                    <option value="">Alege categoria</option>
                                    @php
                                        $allCats = \App\Models\Category::orderBy('name')->get();
                                        if (!function_exists('renderCatOpts')) {
                                            function renderCatOpts($cats, $parentId = '0', $prefix = '') {
                                                $children = $cats->where('subcat', $parentId)->sortBy('name');
                                                foreach ($children as $c) {
                                                    echo '<option value="'.$c->id.'">'.$prefix.$c->name.'</option>';
                                                    renderCatOpts($cats, $c->id, $prefix.'— ');
                                                }
                                            }
                                        }
                                        renderCatOpts($allCats);
                                    @endphp
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary" id="bulk-submit" disabled>
                                    <i class="fas fa-check"></i> Aplică
                                </button>
                                <span id="selected-count" class="ml-2 text-muted">0 produse selectate</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped projects">
                            <thead>
                            <tr>
                                <th style="width: 1%">
                                    <input type="checkbox" id="select-all">
                                </th>
                                <th style="width: 1%">
                                    ID
                                </th>
                                <th style="width: 5%" class="d-none d-md-table-cell">
                                    Imagine
                                </th>
                                <th style="width: 30%">
                                    Denumirea
                                </th>
                                <th style="width: 15%" class="d-none d-lg-table-cell">
                                    Categoria
                                </th>
                                <th style="width: 8%" class="text-center">
                                    Preț
                                </th>
                                <th style="width: 5%" class="text-center d-none d-sm-table-cell">
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
                                        <input type="checkbox" name="selected_products[]" value="{{ $product['id'] }}" class="product-checkbox" form="bulk-action-form">
                                    </td>
                                    <td>
                                        {{ $product['id'] }}
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        @php
                                            $images = json_decode($product['img'], true);
                                            $firstImage = is_array($images) && count($images) > 0 ? $images[0] : null;
                                        @endphp
                                        @if($firstImage)
                                            <img src="{{ asset('storage/products/' . $firstImage) }}" 
                                                 alt="{{ $product['name'] }}" 
                                                 class="img-thumbnail"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary text-white d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px; font-size: 10px;">
                                                Fără<br>imagine
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a>
                                            <b>{{ $product['name'] }}</b>
                                        </a>
                                        <br>
                                        <small class="text-muted">
                                            SKU: {{ $product['sku'] ?? 'N/A' }}
                                        </small>
                                        <!-- Afișare categorie pe mobil -->
                                        <div class="d-lg-none">
                                            <small class="text-info">
                                                @if($product->category)
                                                    @php
                                                        $mchain = collect();
                                                        $mcur = $product->category;
                                                        $mchain->prepend($mcur->name);
                                                        while ($mcur->subcat != '0' && $mcur->parent) {
                                                            $mcur = $mcur->parent;
                                                            $mchain->prepend($mcur->name);
                                                        }
                                                    @endphp
                                                    {{ $mchain->implode(' — ') }}
                                                @else
                                                    Fără categorie
                                                @endif
                                            </small>
                                        </div>
                                        <!-- Afișare status pe mobil -->
                                        <div class="d-sm-none mt-1">
                                            @if ($product['active'] == '1')
                                                <span class="badge badge-success badge-sm">Activat</span>
                                            @elseif($product['active'] == '0')
                                                <span class="badge badge-danger badge-sm">Dezactivat</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="d-none d-lg-table-cell">
                                        @if($product->category)
                                            @php
                                                $chain = collect();
                                                $cur = $product->category;
                                                $chain->prepend($cur->name);
                                                while ($cur->subcat != '0' && $cur->parent) {
                                                    $cur = $cur->parent;
                                                    $chain->prepend($cur->name);
                                                }
                                            @endphp
                                            @if($chain->count() > 1)
                                                <span class="text-muted">{{ $chain->first() }}</span><br>
                                                <small>{{ $chain->skip(1)->implode(' — ') }}</small>
                                            @else
                                                {{ $chain->first() }}
                                            @endif
                                        @else
                                            <span class="text-muted">Fără categorie</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @php
                                            // Determinăm prețul de bază (special sau normal)
                                            $basePrice = ($product['special_price'] && $product['special_price'] > 0) 
                                                ? $product['special_price'] 
                                                : $product['price'];
                                            
                                            // Calculăm prețul în MDL
                                            $priceMdl = null;
                                            if ($curs && $site_settings && (float)$curs->usd_sell > 0) {
                                                $percent = $basePrice < 100 ? 20 : (float)$site_settings->price_procent;
                                                $markup = 1 + ($percent / 100);
                                                $priceMdl = (int) ceil((float)$basePrice * (float)$curs->usd_sell * $markup);
                                            }
                                        @endphp
                                        
                                        @if($product['special_price'] && $product['special_price'] > 0)
                                            <span class="text-danger font-weight-bold">${{ number_format($product['special_price'], 0) }}</span><br>
                                            <small><s class="text-muted">${{ number_format($product['price'], 0) }}</s></small>
                                        @else
                                            <span class="font-weight-bold">${{ number_format($product['price'], 0) }}</span>
                                        @endif
                                        
                                        @if($priceMdl)
                                            <br><small class="text-muted">{{ number_format($priceMdl, 0) }} MDL</small>
                                        @endif
                                    </td>
                                    <td class="project-state d-none d-sm-table-cell">
                                        @if ($product['active'] == '1')
                                            <span class="badge badge-success">Activat</span>
                                        @elseif($product['active'] == '0')
                                            <span class="badge badge-danger">Dezactivat</span>
                                        @endif
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-info btn-sm" href="{{ route('products.edit', $product['id']) }}">
                                            <i class="fas fa-pencil-alt"></i>
                                            <span class="d-none d-md-inline">Edit</span>
                                        </a>
                                        <form action="{{ route('products.destroy', $product['id']) }}" method="POST"
                                              style="display: inline-block;" 
                                              onsubmit="return confirm('Ești sigur că vrei să ștergi acest produs? Această acțiune nu poate fi anulată și va șterge și toate imaginile asociate.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                <i class="fas fa-trash"></i>
                                                <span class="d-none d-md-inline">Delete</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="d-flex justify-content-center" style="padding-top: 10px;">
                {{ $produse->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const bulkSubmit = document.getElementById('bulk-submit');
            const selectedCount = document.getElementById('selected-count');
            const bulkActionForm = document.getElementById('bulk-action-form');
            const bulkActionSelect = document.getElementById('bulk-action-select');
            const categorySelectWrapper = document.getElementById('category-select-wrapper');
            const categorySelect = document.getElementById('category-select');

            // Afișează/ascunde dropdown-ul de categorii în funcție de acțiunea selectată
            bulkActionSelect.addEventListener('change', function() {
                if (this.value === 'change_category') {
                    categorySelectWrapper.style.display = 'block';
                    categorySelect.required = true;
                } else {
                    categorySelectWrapper.style.display = 'none';
                    categorySelect.required = false;
                    categorySelect.value = '';
                }
                updateBulkControls();
            });

            // Funcție pentru actualizarea contorului și stării butonului
            function updateBulkControls() {
                const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                const count = checkedBoxes.length;
                const action = bulkActionSelect.value;
                
                selectedCount.textContent = count + ' produse selectate';
                
                // Butonul este activ doar dacă:
                // - sunt produse selectate
                // - și (acțiunea nu este change_category SAU categoria este selectată)
                const canSubmit = count > 0 && (action !== 'change_category' || categorySelect.value !== '');
                bulkSubmit.disabled = !canSubmit;
                
                // Actualizează starea checkbox-ului "Selectează tot"
                if (count === 0) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = false;
                } else if (count === productCheckboxes.length) {
                    selectAllCheckbox.indeterminate = false;
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.indeterminate = true;
                }
            }

            // Event listener pentru "Selectează tot"
            selectAllCheckbox.addEventListener('change', function() {
                productCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                updateBulkControls();
            });

            // Event listeners pentru checkbox-urile individuale
            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkControls);
            });

            // Event listener pentru selectarea categoriei
            categorySelect.addEventListener('change', updateBulkControls);

            // Confirmarea pentru acțiunile în masă
            bulkActionForm.addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                const action = bulkActionSelect.value;
                let confirmMessage = '';
                
                if (action === 'activate') {
                    confirmMessage = `Ești sigur că vrei să activezi ${checkedBoxes.length} produse?`;
                } else if (action === 'deactivate') {
                    confirmMessage = `Ești sigur că vrei să dezactivezi ${checkedBoxes.length} produse?`;
                } else if (action === 'change_category') {
                    const categoryName = categorySelect.options[categorySelect.selectedIndex].text;
                    confirmMessage = `Ești sigur că vrei să muți ${checkedBoxes.length} produse în categoria "${categoryName}"?`;
                }
                
                if (!confirm(confirmMessage)) {
                    e.preventDefault();
                }
            });

            // Inițializează starea controalelor
            updateBulkControls();
        });
    </script>
@endsection
