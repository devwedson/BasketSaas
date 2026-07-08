<div class="text-center my-4">
    @if (!empty($registerText) && !empty($registerUrl))
        <p class="text-muted">{{ $registerText }} <a href="{{ $registerUrl }}" class="text-muted ms-1 link-offset-3 underline underline-offset-4"><b>{{ $registerLinkLabel }}</b></a></p>
    @endif

    @if (!empty($secondaryUrl))
        <p class="text-muted mt-2"><a href="{{ $secondaryUrl }}" class="text-muted underline underline-offset-4">{{ $secondaryLabel }}</a></p>
    @endif

    <button id="light-dark-mode" type="button" class="mt-3 text-muted text-sm hover:text-primary inline-flex items-center gap-1.5 mx-auto border-0 bg-transparent">
        <i class="ri-moon-line text-base dark:hidden"></i>
        <i class="ri-sun-line text-base hidden dark:inline"></i>
        Alternar tema
    </button>
</div>