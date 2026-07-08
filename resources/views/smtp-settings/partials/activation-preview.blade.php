<div id="smtp-preview-card" class="card flex flex-col h-full min-h-0">
    <div class="card-header flex flex-wrap justify-between items-center gap-2 shrink-0">
        <div>
            <h4 class="card-title">Prévia — Ativação de Conta</h4>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $previewSubject }}</p>
        </div>
        <a href="{{ route('smtp.settings.preview.activation.frame') }}" target="_blank" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200 shrink-0">
            <i class="ri-fullscreen-line me-1"></i> Expandir
        </a>
    </div>

    <div class="px-6 pb-4 shrink-0">
        <dl class="grid grid-cols-2 gap-3 text-xs">
            <div>
                <dt class="text-gray-500 dark:text-gray-400">De</dt>
                <dd class="font-medium text-gray-800 dark:text-gray-200 truncate">{{ $previewFromName }}</dd>
            </div>
            <div>
                <dt class="text-gray-500 dark:text-gray-400">Para (ex.)</dt>
                <dd class="font-medium text-gray-800 dark:text-gray-200 truncate">{{ $previewSampleEmail }}</dd>
            </div>
        </dl>
    </div>

    <div class="flex flex-col flex-1 min-h-0 border-t border-gray-100 dark:border-gray-700">
        <div class="flex flex-col flex-1 min-h-0 bg-light/30 dark:bg-light/5 p-3 md:p-4">
            <div class="relative flex-1 min-h-[320px] overflow-hidden rounded-md border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shadow-sm">
                <iframe
                    src="{{ route('smtp.settings.preview.activation.frame') }}"
                    title="Prévia do e-mail de ativação"
                    class="absolute inset-0 w-full h-full border-0"
                ></iframe>
            </div>
        </div>
    </div>
</div>