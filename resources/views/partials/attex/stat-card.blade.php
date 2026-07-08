<div class="card">
    <div class="p-6">
        <div class="flex justify-between items-start gap-4">
            <div class="grow overflow-hidden">
                @if (!empty($icon))
                    <div class="flex items-center gap-2 mb-2">
                        <span class="flex items-center justify-center h-9 w-9 rounded-full bg-primary/10 text-primary">
                            <i class="{{ $icon }} text-lg"></i>
                        </span>
                    </div>
                @endif
                <h5 class="text-base/3 text-gray-400 dark:text-gray-500 font-normal mt-0">{{ $label }}</h5>
                <h3 class="text-2xl my-3 text-slate-900 dark:text-slate-100">{{ $value }}</h3>
                @if (!empty($hint))
                    <p class="text-gray-400 dark:text-gray-500 truncate text-sm">{{ $hint }}</p>
                @endif
            </div>
        </div>
    </div>
</div>