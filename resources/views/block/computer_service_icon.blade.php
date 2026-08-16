<span class="laptop-service-icon" aria-hidden="true">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
@switch($slug)
@case('diagnosticare')<path d="M4 4h16v12H4zM8 20h8M12 16v4"/><path d="m9 10 2 2 4-5"/>@break
@case('curatare-racire')
    <rect x="2.5" y="2.5" width="19" height="19" rx="3"/>
    <circle cx="12" cy="12" r="7.2"/>
    <circle cx="12" cy="12" r="1.7"/>
    <path d="M12 10.3c-.8-1.9-.5-4.7 1.2-5.3 1.8-.6 3.4 1.5 2.6 3.3-.5 1.2-1.6 2.2-2.7 2.9M13.7 12c1.9-.8 4.7-.5 5.3 1.2.6 1.8-1.5 3.4-3.3 2.6-1.2-.5-2.2-1.6-2.9-2.7M12 13.7c.8 1.9.5 4.7-1.2 5.3-1.8.6-3.4-1.5-2.6-3.3.5-1.2 1.6-2.2 2.7-2.9M10.3 12c-1.9.8-4.7.5-5.3-1.2-.6-1.8 1.5-3.4 3.3-2.6 1.2.5 2.2 1.6 2.9 2.7"/>
    <path d="M5 5h.01M19 5h.01M5 19h.01M19 19h.01" stroke-width="2.4"/>
@break
@case('sursa-alimentare')<path d="M13 2 5 13h6l-1 9 9-13h-6z"/>@break
@case('reparatie-placa-de-baza')<rect x="5" y="5" width="14" height="14" rx="2"/><rect x="9" y="9" width="6" height="6" rx="1"/><path d="M9 2v3M15 2v3M9 19v3M15 19v3M2 9h3M2 15h3M19 9h3M19 15h3"/>@break
@case('upgrade-ssd-ram')<rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="7" cy="12" r="1.5"/><path d="M11 10h7M11 14h7M6 3v3M10 3v3M14 3v3M18 3v3M6 18v3M10 18v3M14 18v3M18 18v3"/>@break
@case('placa-video')<rect x="3" y="6" width="16" height="12" rx="2"/><circle cx="10" cy="12" r="4"/><path d="M19 9h2v6h-2M6 3v3M10 3v3M14 3v3"/>@break
@case('instalare-windows')<path d="m3 5 8-1v7H3V5ZM13 3.7 21 2v9h-8V3.7ZM3 13h8v7l-8-1v-6ZM13 13h8v9l-8-1.7V13Z"/>@break
@case('recuperare-date')<path d="M4 5h16v14H4zM8 9h8M8 13h5"/><path d="m15 16 2 2 4-5"/>@break
@case('calculator-nu-porneste')<rect x="3" y="3" width="14" height="18" rx="2"/><circle cx="10" cy="7" r="1"/><path d="M20 8v5M17.5 10.5h5M19 17h2"/>@break
@case('asamblare-pc')<path d="M14.7 6.3a4 4 0 0 0-5-5L12 3.6 9.6 6 7.3 3.7a4 4 0 0 0 5 5L20 16.4a2.5 2.5 0 0 1-3.6 3.6l-7.7-7.7"/><path d="m5 13-3 3 6 6 3-3"/>@break
@case('configurare-bios')<rect x="5" y="5" width="14" height="14" rx="2"/><path d="M9 2v3M15 2v3M9 19v3M15 19v3M2 9h3M19 9h3M2 15h3M19 15h3M9 10h6M9 14h4"/>@break
@case('virusi-optimizare')<path d="M12 3 4 6v5c0 5.2 3.2 8.5 8 10 4.8-1.5 8-4.8 8-10V6z"/><path d="m8.5 12 2.2 2.2 4.8-5"/>@break
@case('service-domiciliu')<path d="m3 11 9-8 9 8M5 10v11h14V10M9 21v-7h6v7"/><path d="M17 5h3v3"/>@break
@endswitch
</svg></span>
