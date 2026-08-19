<span class="laptop-service-icon" aria-hidden="true">
<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
@switch($slug)
@case('diagnosticare-mfd')<rect x="5" y="3" width="14" height="6" rx="1"/><rect x="3" y="9" width="18" height="9" rx="2"/><path d="M7 18v3h10v-3M7 13h6M17 12h.01"/>@break
@case('reparatie-alimentare')<path d="M13 2 5 13h6l-1 9 9-13h-6z"/>@break
@case('reparatie-mecanism-hartie')<rect x="4" y="5" width="16" height="14" rx="2"/><path d="M8 2h8v5H8zM7 14h10M8 18h8M8 10h.01"/>@break
@case('reparatie-calitate-imprimare')<path d="M5 3h14v18H5zM8 7h8M8 11h8M8 15h5"/><circle cx="17" cy="16" r="2"/>@break
@case('reparatie-scaner')<path d="m4 8 3-5h10l3 5M3 9h18v11H3zM7 13h10M7 16h7"/>@break
@default <path d="M4 7h16v12H4zM7 3h10v4M8 12h8M8 15h6"/><path d="m18 2 1 2 2 1-2 1-1 2-1-2-2-1 2-1z"/>
@endswitch
</svg></span>
