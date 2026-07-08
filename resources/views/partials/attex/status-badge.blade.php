<span class="inline-flex items-center py-1 px-2.5 rounded-md text-xs font-medium {{ ($active ?? false) ? 'bg-success/15 text-success' : 'bg-danger/15 text-danger' }}">
    {{ ($active ?? false) ? ($activeLabel ?? 'Ativo') : ($inactiveLabel ?? 'Inativo') }}
</span>