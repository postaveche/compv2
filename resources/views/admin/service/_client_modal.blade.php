<div class="modal fade" id="new-client-modal" tabindex="-1" role="dialog" aria-labelledby="new-client-title" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document"><div class="modal-content">
<form id="new-client-form" action="{{ route('service.clients.store') }}" method="POST">
@csrf
<div class="modal-header">
<h5 class="modal-title" id="new-client-title">Client nou</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Inchide"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
<div id="new-client-errors" class="alert alert-danger d-none" role="alert"></div>
@include('admin.service._client_fields', ['client' => null])
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Anuleaza</button>
<button type="submit" class="btn btn-primary">Salveaza</button>
</div>
</form>
</div></div>
</div>
<script>
document.getElementById('client-type').addEventListener('change', function () {
    document.getElementById('juridica-fields').style.display = this.value === 'juridica' ? '' : 'none';
});
document.getElementById('new-client-form').addEventListener('submit', async function (event) {
    event.preventDefault();
    const button = this.querySelector('[type="submit"]');
    const errors = document.getElementById('new-client-errors');
    errors.classList.add('d-none');
    errors.textContent = '';
    button.disabled = true;
    try {
        const response = await fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();
        if (!response.ok) {
            const messages = data.errors ? Object.values(data.errors).flat() : [data.message || 'Clientul nu a putut fi salvat.'];
            throw new Error(messages.join(' '));
        }
        const select = document.getElementById('client-select');
        if (select) {
            const client = data.client;
            select.add(new Option(client.name + ' - ' + client.phone, client.id, true, true));
            document.getElementById('client-search').value = client.name + ' - ' + client.phone;
            document.getElementById('client-results').innerHTML = '';
            select.dispatchEvent(new Event('change'));
            window.jQuery('#new-client-modal').modal('hide');
            this.reset();
            document.getElementById('juridica-fields').style.display = 'none';
            button.disabled = false;
        } else {
            window.location.reload();
        }
    } catch (error) {
        errors.textContent = error.message || 'Eroare la salvare. Incercati din nou.';
        errors.classList.remove('d-none');
        button.disabled = false;
    }
});
</script>
