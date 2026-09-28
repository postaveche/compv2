# Casă

Acces: meniul **Casă**, `/admincp/cash`, după autentificarea în admin.
Parola separată se configurează prin `CASH_PASSWORD` în `.env`. Fără o parolă
configurată accesul rămâne blocat. Dacă proiectul folosește configurația cache,
rulează `php artisan config:cache` după schimbarea parolei.

Parola greșită returnează un răspuns HTML gol și revocă accesul anterior.
După 5 încercări greșite accesul este limitat timp de un minut. Parola corectă
deblochează registrul pentru 30 de minute; butonul „Blochează accesul” îl închide
imediat. Deblocarea este legată de utilizator și de parola curentă.

Încasările manuale au client, descriere, sumă MDL, metodă (Cash, Cec, Transfer),
dată și oră. Datele sunt în fusul orar al aplicației (Europe/Chisinau).
Retrimiterea aceluiași formular nu creează o a doua încasare.

În service:

- Avansul se înregistrează separat la creare sau modificare.
- Bifarea „Achitat” înregistrează prețul final minus avansul.
- Taxa de diagnosticare bifată ca achitată se înregistrează separat.
- O sumă nouă necesită metoda de plată; data necompletată înseamnă momentul salvării.
- Salvarea repetată fără schimbarea sumelor/stării de plată nu dublează încasarea.
- Debifarea sau corectarea unei sume anulează înregistrarea anterioară, păstrând-o
  în istoric. La corectare se creează o înregistrare pentru noua sumă, cu metoda
  și data selectate. Aceasta este o corecție a înregistrării, nu un flux de rambursare.
- Avansul este totalul avansului comenzii. Modificarea lui este tratată ca o
  corecție a acestui total, nu ca o tranșă suplimentară.
- Încasările vechi nu sunt importate la instalare sau la editări fără schimbări
  ale valorilor de plată. La prima corectare a unei valori vechi se înregistrează
  valoarea corectată; verifică atunci metoda și data efectivă.
- Ștergerea unei comenzi sau a unui client păstrează încasările și numele clientului
  din momentul înregistrării.

Totalurile respectă filtrele și exclud înregistrările anulate. Registrul arată
încasări; nu calculează soldul fizic al casei și nu include cheltuieli.

Instalare pe alt mediu: configurează `CASH_PASSWORD`, apoi rulează
`php artisan migrate --path=database/migrations/2026_09_28_000001_create_cash_entries_table.php`.
Nu copia parola mediului local într-un fișier urmărit de Git.

Teste izolate: `php artisan test --filter=CashRegisterTest` (SQLite în memorie).
