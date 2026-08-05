<span class="laptop-service-icon" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
        @switch($slug)
            @case('schimbare-ecran')
                <rect x="3" y="4" width="18" height="13" rx="2"/><path d="M8 21h8M12 17v4"/><path d="m15.5 7-7 7M10 7H8a1 1 0 0 0-1 1v2"/>
                @break
            @case('schimbare-tastatura')
                <rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="M6 9h.01M9 9h.01M12 9h.01M15 9h.01M18 9h.01M6 12h.01M9 12h.01M12 12h.01M15 12h.01M18 12h.01M7 15h10"/>
                @break
            @case('curatare-racire')
                <circle cx="12" cy="12" r="3"/><path d="M12 9c-1.5-3.5.1-5.8 2.2-5.8 2.4 0 3 3.3.8 5.8M15 12c3.5-1.5 5.8.1 5.8 2.2 0 2.4-3.3 3-5.8.8M12 15c1.5 3.5-.1 5.8-2.2 5.8-2.4 0-3-3.3-.8-5.8M9 12c-3.5 1.5-5.8-.1-5.8-2.2 0-2.4 3.3-3 5.8-.8"/>
                @break
            @case('schimbare-baterie')
                <rect x="3" y="7" width="17" height="10" rx="2"/><path d="M20 10h1.5v4H20M10 9.5 7.5 13H11l-1 2.5 4-4H11l1-2"/>
                @break
            @case('upgrade-ssd-ram')
                <rect x="3" y="6" width="18" height="12" rx="2"/><circle cx="7" cy="12" r="1.5"/><path d="M11 10h7M11 14h7M6 3v3M10 3v3M14 3v3M18 3v3M6 18v3M10 18v3M14 18v3M18 18v3"/>
                @break
            @case('reparatie-mufa-alimentare')
                <path d="M8 3v6M16 3v6M6 9h12v2a6 6 0 0 1-6 6v4M9 13h6"/>
                @break
            @case('reparatie-placa-de-baza')
                <rect x="5" y="5" width="14" height="14" rx="2"/><rect x="9" y="9" width="6" height="6" rx="1"/><path d="M9 2v3M15 2v3M9 19v3M15 19v3M2 9h3M2 15h3M19 9h3M19 15h3"/>
                @break
            @case('instalare-windows')
                <path d="m3 5 8-1v7H3V5ZM13 3.7 21 2v9h-8V3.7ZM3 13h8v7l-8-1v-6ZM13 13h8v9l-8-1.7V13Z"/>
                @break
        @endswitch
    </svg>
</span>
