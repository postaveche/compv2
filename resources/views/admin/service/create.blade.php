@extends('admin.layouts.adminlayouts')
@section('title', 'Comanda noua')
@section('content')
<div class="content-wrapper">
<section class="content-header"><div class="container-fluid"><h1>Comanda noua de reparatie</h1></div></section>
<section class="content"><div class="container-fluid">
@include('admin.block.messages')
<form action="{{ route('service.store') }}" method="POST" enctype="multipart/form-data">@csrf

<div class="card card-info">
<div class="card-header"><h3 class="card-title">Client</h3></div>
<div class="card-body">
<div class="row">
<div class="col-md-4"><label>Cauta client existent</label>
<input type="text" id="client-search" class="form-control" placeholder="Nume sau telefon...">
<div id="client-results" class="list-group" style="position:absolute;z-index:100;width:90%;"></div></div>
<div class="col-md-4"><label>Client selectat</label>
<select name="client_id" id="client-select" class="form-control" required>
<option value="">Selecteaza client</option>
@foreach($clients as $c)<option value="{{ $c->id }}">{{ $c->name }} - {{ $c->phone }}</option>@endforeach
</select></div>
<div class="col-md-4"><label>&nbsp;</label><br><a href="{{ route('service.clients.create') }}" class="btn btn-success"><i class="fas fa-plus"></i> Client nou</a></div>
</div></div></div>

<div class="card card-primary">
<div class="card-header"><h3 class="card-title">Dispozitiv</h3></div>
<div class="card-body">
<div class="row mb-3">
<div class="col-md-3">
<label>Dispozitiv nou sau retur?</label>
<select id="is-return" name="is_return" class="form-control">
<option value="0">Dispozitiv nou</option>
<option value="1">Retur (a mai fost la noi)</option>
</select>
</div>
<div class="col-md-3" id="warranty-repair-wrapper" style="display:none;">
<label>&nbsp;</label>
<div class="custom-control custom-checkbox mt-2">
<input type="checkbox" class="custom-control-input" id="is-warranty-repair" name="is_warranty_repair" value="1">
<label class="custom-control-label" for="is-warranty-repair">Reparatie pe garantie</label>
</div>
</div>
<div class="col-md-6" id="prev-order-wrapper" style="display:none;">
<label>Comanda anterioara</label>
<select name="parent_order_id" id="prev-order-select" class="form-control">
<option value="">Selecteaza comanda anterioara...</option>
</select>
<small class="text-muted">Selecteaza clientul mai intai</small>
</div>
</div>
<div class="row">
<div class="col-md-3"><label>Tip dispozitiv *</label>
<select name="device_type" class="form-control" required>
<option value="">Selecteaza</option>
@foreach($deviceTypes as $dt)<option>{{ $dt->name }}</option>@endforeach
</select></div>
<div class="col-md-3"><label>Brand</label><input type="text" name="device_brand" class="form-control" placeholder="HP, Lenovo..."></div>
<div class="col-md-3"><label>Model</label><input type="text" name="device_model" class="form-control" placeholder="Model..."></div>
<div class="col-md-3"><label>Serie (S/N)</label><input type="text" name="serial_number" class="form-control"></div>
</div><div class="row mt-2">
<div class="col-md-6"><label>Accesorii primite</label><input type="text" name="accessories" class="form-control" placeholder="Incarcator, geanta, mouse..."></div>
<div class="col-md-6"><label>Starea dispozitivului</label><input type="text" name="device_condition" class="form-control" placeholder="Zgarieturi, ecran spart..."></div>
</div></div></div>

<div class="card card-warning">
<div class="card-header"><h3 class="card-title">Problema si estimare</h3></div>
<div class="card-body"><div class="row">
<div class="col-md-6"><label>Descrierea problemei *</label><textarea name="problem_description" class="form-control" rows="3" required placeholder="Ce problema are dispozitivul..."></textarea></div>
<div class="col-md-3"><label>Pret estimat (MDL)</label><input type="number" name="estimated_price" class="form-control" step="0.01"></div>
<div class="col-md-3"><label>Avans (MDL)</label><input type="number" name="advance_payment" class="form-control" step="0.01" value="0"></div>
<div class="col-md-3"><label>Data estimata finalizare</label><input type="date" name="estimated_completion" class="form-control"></div>
</div><div class="row mt-2">
<div class="col-md-6"><label>Note interne</label><textarea name="notes" class="form-control" rows="2" placeholder="Note vizibile doar in admin..."></textarea></div>
<div class="col-md-6"><label>Poze dispozitiv (la primire)</label><input type="file" name="photos[]" class="form-control-file" multiple accept="image/*"><small class="text-muted">Poti selecta mai multe poze</small></div>
</div></div></div>

<div class="mb-3">
<button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Creaza comanda si genereaza act</button>
<a href="{{ route('service.index') }}" class="btn btn-secondary btn-lg">Anuleaza</a>
</div>
</form></div></section></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('client-search');
    var results = document.getElementById('client-results');
    var select = document.getElementById('client-select');
    var isReturn = document.getElementById('is-return');
    var prevWrapper = document.getElementById('prev-order-wrapper');
    var prevSelect = document.getElementById('prev-order-select');
    var timer;

    // Cautare client
    searchInput.addEventListener('input', function() {
        clearTimeout(timer);
        var q = this.value;
        if (q.length < 2) { results.innerHTML = ''; return; }
        timer = setTimeout(function() {
            fetch('{{ route("service.search.client") }}?q=' + encodeURIComponent(q))
            .then(function(r) { return r.json(); })
            .then(function(data) {
                results.innerHTML = '';
                data.forEach(function(c) {
                    var a = document.createElement('a');
                    a.href = '#';
                    a.className = 'list-group-item list-group-item-action';
                    a.textContent = c.name + ' - ' + c.phone;
                    a.addEventListener('click', function(e) {
                        e.preventDefault();
                        select.value = c.id;
                        searchInput.value = c.name + ' - ' + c.phone;
                        results.innerHTML = '';
                        loadClientOrders(c.id);
                    });
                    results.appendChild(a);
                });
            });
        }, 300);
    });

    // Cand se schimba clientul din dropdown
    select.addEventListener('change', function() {
        if (this.value) loadClientOrders(this.value);
    });

    // Toggle retur
    isReturn.addEventListener('change', function() {
        var isRet = this.value === '1';
        prevWrapper.style.display = isRet ? '' : 'none';
        document.getElementById('warranty-repair-wrapper').style.display = isRet ? '' : 'none';
        if (!isRet) {
            prevSelect.value = '';
            document.getElementById('is-warranty-repair').checked = false;
        }
    });

    // Incarca comenzile anterioare ale clientului
    function loadClientOrders(clientId) {
        fetch('{{ url("admincp/service/api/client-orders") }}/' + clientId)
        .then(function(r) { return r.json(); })
        .then(function(orders) {
            prevSelect.innerHTML = '<option value="">Selecteaza comanda anterioara...</option>';
            orders.forEach(function(o) {
                var opt = document.createElement('option');
                opt.value = o.id;
                var date = new Date(o.created_at).toLocaleDateString('ro-RO');
                opt.textContent = o.order_number + ' - ' + o.device_type + ' ' + (o.device_brand || '') + ' ' + (o.device_model || '') + ' (' + date + ')';
                opt.dataset.type = o.device_type;
                opt.dataset.brand = o.device_brand || '';
                opt.dataset.model = o.device_model || '';
                opt.dataset.serial = o.serial_number || '';
                prevSelect.appendChild(opt);
            });
        });
    }

    // Auto-completare campuri din comanda anterioara
    prevSelect.addEventListener('change', function() {
        var opt = this.options[this.selectedIndex];
        if (opt.value) {
            var typeField = document.querySelector('[name="device_type"]');
            var brandField = document.querySelector('[name="device_brand"]');
            var modelField = document.querySelector('[name="device_model"]');
            var serialField = document.querySelector('[name="serial_number"]');
            if (opt.dataset.type) typeField.value = opt.dataset.type;
            if (opt.dataset.brand) brandField.value = opt.dataset.brand;
            if (opt.dataset.model) modelField.value = opt.dataset.model;
            if (opt.dataset.serial) serialField.value = opt.dataset.serial;
        }
    });
});
</script>
@endsection
