@extends('admin.layouts.adminlayouts')

@yield('title', 'Administrare produse')

@section('content')
    <div class="content-wrapper">
        <div class="container">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <h1>Toate produsele disponibile:</h1>
                </div>
            </div>
        </section>
        @include('admin.block.filter')
        <section class="content">
            @include('admin.block.messages')
            <p><a class="btn btn-info btn-sm" href="{{ route('products.create') }}"><i class="nav-icon fas fa-edit"></i>
                    <b>Adauga Produs</b></a></p>

            <!-- Controale pentru acțiuni în masă -->
            <div class="card mb-3">
                <div class="card-body">
                    <form id="bulk-action-form" action="{{ route('products.bulk-update') }}" method="POST">
                        @csrf
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <label class="form-label">Acțiuni în masă:</label>
                                <select name="bulk_action" class="form-control" required>
                                    <option value="">Selectează acțiunea</option>
                                    <option value="activate">Activează produsele selectate</option>
                                    <option value="deactivate">Dezactivează produsele selectate</option>
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
                    <table class="table table-striped projects">
                        <thead>
                        <tr>
                            <th style="width: 1%">
                                <input type="checkbox" id="select-all">
                            </th>
                            <th style="width: 1%">
                                ID
                            </th>
                            <th style="width: 54%">
                                Denumirea
                            </th>
                            <th style="width: 5%">
                                Subcategorie
                            </th>
                            <th style="width: 5%" class="text-center">
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
                                <td>
                                    <a>
                                        <b>{{ $product['name'] }}</b>
                                    </a>
                                    <br>
                                    <small>
                                        {{$product->category->name}}
                                    </small>
                                </td>
                                <td class="project_progress">
                                    {{$product['']}}
                                </td>
                                <td class="project-state">
                                    @if ($product['active'] == '1')
                                        <span class="badge badge-success">Activat</span>
                                    @elseif($product['active'] == '0')
                                        <span class="badge badge-danger">Dezactivat</span>
                                    @endif
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="{{ route('products.edit', $product['id']) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <form action="{{ route('products.destroy', $product['id']) }}" method="POST"
                                          style="display: inline-block;" 
                                          onsubmit="return confirm('Ești sigur că vrei să ștergi acest produs? Această acțiune nu poate fi anulată și va șterge și toate imaginile asociate.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                            <i class="fas fa-trash">
                                            </i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <div class="d-flex justify-content-center" style="padding-top: 10px;">
                {{ $produse->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </section>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const bulkSubmit = document.getElementById('bulk-submit');
            const selectedCount = document.getElementById('selected-count');
            const bulkActionForm = document.getElementById('bulk-action-form');

            // Funcție pentru actualizarea contorului și stării butonului
            function updateBulkControls() {
                const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                const count = checkedBoxes.length;
                
                selectedCount.textContent = count + ' produse selectate';
                bulkSubmit.disabled = count === 0;
                
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

            // Confirmarea pentru acțiunile în masă
            bulkActionForm.addEventListener('submit', function(e) {
                const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                const action = document.querySelector('select[name="bulk_action"]').value;
                const actionText = action === 'activate' ? 'activa' : 'dezactiva';
                
                if (!confirm(`Ești sigur că vrei să ${actionText} ${checkedBoxes.length} produse?`)) {
                    e.preventDefault();
                }
            });

            // Inițializează starea controalelor
            updateBulkControls();
        });
    </script>
@endsection
