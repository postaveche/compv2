<span class="laptop-process__icon" aria-hidden="true">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
        @switch($step)
            @case(1)
                <path d="M8 7V5a4 4 0 0 1 8 0v2"/>
                <rect x="3" y="7" width="18" height="13" rx="2"/>
                <path d="M3 12h18M9 12v2h6v-2"/>
                @break
            @case(2)
                <circle cx="10.5" cy="10.5" r="6.5"/>
                <path d="m15.5 15.5 4.5 4.5M8 10.5l1.7 1.7 3.5-4"/>
                @break
            @case(3)
                <path d="M5 3h14a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-7l-5 4v-4H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                <path d="m8 10 2.2 2.2L16 7"/>
                @break
            @case(4)
                <path d="M14.7 6.3a4 4 0 0 0-5-5L12 3.6 9.6 6 7.3 3.7a4 4 0 0 0 5 5L20 16.4a2.5 2.5 0 0 1-3.6 3.6l-7.7-7.7"/>
                <path d="m5 13-3 3 6 6 3-3M14 14l2-2"/>
                @break
            @case(5)
                <path d="M6 2h9l4 4v16H6zM15 2v5h5M9 12h6M9 16h6"/>
                <path d="M3 6v13h3"/>
                @break
            @default
                <path d="M3 7h11v10H3zM14 10h4l3 3v4h-7z"/>
                <circle cx="7" cy="18" r="2"/><circle cx="18" cy="18" r="2"/>
                <path d="M6 4h8M3 11h5"/>
        @endswitch
    </svg>
</span>
