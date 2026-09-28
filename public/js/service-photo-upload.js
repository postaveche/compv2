(function () {
    'use strict';

    var form = document.getElementById('service-photo-upload');
    if (!form || !window.fetch || !window.FormData) return;

    var button = form.querySelector('button[type="submit"]');
    var errors = form.querySelector('[data-upload-errors]');

    function showErrors(messages) {
        errors.textContent = messages.join(' ');
        errors.classList.remove('d-none');
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        if (button.disabled) return;
        errors.classList.add('d-none');
        var files = form.querySelector('input[type="file"]').files;
        if (!files.length || files.length > 20) {
            showErrors(['Selectează între 1 și 20 de fotografii.']);
            return;
        }
        for (var file of files) {
            if (file.size > 20 * 1024 * 1024) {
                showErrors([file.name + ': fotografia depășește limita de 20 MB.']);
                return;
            }
        }

        button.disabled = true;
        button.textContent = 'Se încarcă pozele…';
        try {
            var response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json' },
                credentials: 'same-origin'
            });
            if (response.status === 422) {
                var result = await response.json();
                showErrors(Object.values(result.errors || {}).flat());
            } else if (response.status === 413) {
                showErrors(['Fotografiile depășesc limita totală a serverului. Încarcă mai puține poze odată sau micșorează-le.']);
            } else if (response.status === 419 || response.status === 401) {
                showErrors(['Sesiunea a expirat. Reîncarcă pagina și autentifică-te din nou.']);
            } else if (!response.ok) {
                showErrors(['Încărcarea a eșuat. Încearcă din nou cu mai puține fotografii.']);
            } else {
                window.location.reload();
            }
        } catch (error) {
            showErrors(['Conexiunea s-a întrerupt. Verifică dacă pozele au apărut în comandă înainte de a reîncerca.']);
        } finally {
            button.disabled = false;
            button.textContent = 'Încarcă poze';
        }
    });
})();
