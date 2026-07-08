<div class="flex items-center justify-end gap-1.5">
    @if (!empty($showUrl))
        <a href="{{ $showUrl }}" class="btn btn-sm bg-light text-dark dark:bg-gray-700 dark:text-gray-200" title="Ver">
            <i class="ri-eye-line"></i>
        </a>
    @endif
    @if (!empty($editUrl))
        <a href="{{ $editUrl }}" class="btn btn-sm bg-primary/10 text-primary" title="Editar">
            <i class="ri-pencil-line"></i>
        </a>
    @endif
    @if (!empty($deleteUrl))
        <form method="POST" action="{{ $deleteUrl }}" class="inline" onsubmit="return confirm('{{ $deleteConfirm ?? 'Confirma a exclusão deste registro?' }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm bg-danger/10 text-danger" title="Excluir">
                <i class="ri-delete-bin-line"></i>
            </button>
        </form>
    @endif
</div>