<button type="button" class="btn btn-sm btn-outline-primary translate-all-btn" style="margin-bottom:15px;">
    <i class="fas fa-language"></i> Traducere automata RO → RU
</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mapare câmpuri RO -> RU
    var fieldPairs = {
        'name_ro': 'name_ru',
        'description': 'description_ru',
        'keywords': 'keywords_ru',
        'text': 'text_ru',
        'title_ro': 'title_ru',
        'full_desc_ro': 'full_desc_ru',
    };

    document.querySelectorAll('.translate-all-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var texts = {};
            var foundFields = {};

            // Colectăm textele din câmpurile RO
            for (var roField in fieldPairs) {
                var ruField = fieldPairs[roField];
                var roEl = document.querySelector('[name="' + roField + '"]');
                var ruEl = document.querySelector('[name="' + ruField + '"]');
                if (roEl && ruEl) {
                    // Verificăm dacă e TinyMCE
                    var roValue = '';
                    if (typeof tinymce !== 'undefined' && tinymce.get(roEl.id)) {
                        roValue = tinymce.get(roEl.id).getContent();
                    } else {
                        roValue = roEl.value;
                    }
                    if (roValue.trim() !== '') {
                        texts[roField] = roValue;
                        foundFields[roField] = ruField;
                    }
                }
            }

            if (Object.keys(texts).length === 0) {
                alert('Nu sunt campuri RO completate pentru traducere.');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Se traduce...';

            fetch('{{ route("admin.translate.batch") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ texts: texts, from: 'ro', to: 'ru' })
            })
            .then(function(r) { return r.json(); })
            .then(function(data) {
                for (var roField in data.translated) {
                    var ruField = foundFields[roField];
                    var ruEl = document.querySelector('[name="' + ruField + '"]');
                    if (ruEl) {
                        // Verificăm dacă e TinyMCE
                        if (typeof tinymce !== 'undefined' && tinymce.get(ruEl.id)) {
                            tinymce.get(ruEl.id).setContent(data.translated[roField]);
                        } else {
                            ruEl.value = data.translated[roField];
                        }
                    }
                }
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-check text-success"></i> Tradus!';
                setTimeout(function() {
                    btn.innerHTML = '<i class="fas fa-language"></i> Traducere automata RO → RU';
                }, 2000);
            })
            .catch(function() {
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-times text-danger"></i> Eroare!';
                setTimeout(function() {
                    btn.innerHTML = '<i class="fas fa-language"></i> Traducere automata RO → RU';
                }, 2000);
            });
        });
    });
});
</script>
