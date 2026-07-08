<div class="flex flex-wrap items-center gap-2 pt-2 border-t border-gray-100 dark:border-gray-700 mt-6">
    <button type="submit" class="btn bg-primary text-white">{{ $submitLabel ?? 'Salvar' }}</button>
    <a href="{{ $cancelUrl }}" class="btn bg-light text-dark dark:bg-gray-700 dark:text-gray-200">{{ $cancelLabel ?? 'Cancelar' }}</a>
</div>