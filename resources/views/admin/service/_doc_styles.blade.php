<style>
body { font-family: {{ $isPdf ?? false ? 'DejaVu Sans, sans-serif' : 'Arial, sans-serif' }}; font-size: 11px; margin: 10px; color: #333; line-height: 1.3; }
.header { margin-bottom: 8px; padding-bottom: 5px; }
.order-number { font-size: 13px; font-weight: bold; text-align: right; margin-bottom: 8px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 6px; }
table th, table td { border: 1px solid #999; padding: 3px 5px; text-align: left; }
table th { background: #f0f0f0; width: 160px; }
.section-title { font-weight: bold; font-size: 11px; margin: 8px 0 3px; background: #eee; padding: 3px; }
.terms { font-size: 8px; color: #666; margin-top: 10px; border-top: 1px solid #ccc; padding-top: 5px; }
.sig-table { width: 100%; margin-top: 25px; border: none; }
.sig-table td { width: 50%; text-align: center; border: none; padding-top: 25px; border-top: 1px solid #333; font-size: 10px; }
.no-print { margin-bottom: 15px; }
@media print { .no-print { display: none; } body { margin: 10mm; } @page { margin: 0; } }
</style>
