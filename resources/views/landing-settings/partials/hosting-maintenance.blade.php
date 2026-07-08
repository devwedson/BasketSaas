<div class="card mt-6">
    <div class="card-header border-b border-gray-100 dark:border-gray-700">
        <h4 class="card-title text-base">Hospedagem (sem terminal)</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
            Se logos ou imagens enviadas não aparecem no site, use o botão abaixo. Não é necessário rodar comandos no servidor.
        </p>
    </div>
    <div class="p-6 flex flex-wrap items-center gap-3">
        <form method="POST" action="{{ route('system.maintenance.uploads') }}">
            @csrf
            <button type="submit" class="btn bg-warning text-white">
                <i class="ri-tools-line me-1"></i> Reparar uploads e cache
            </button>
        </form>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-0">
            Publica arquivos antigos e garante a pasta <code class="text-xs">public/storage</code>.
        </p>
    </div>
</div>