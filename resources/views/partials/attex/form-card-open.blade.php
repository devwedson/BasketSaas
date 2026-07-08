<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $formTitle }}</h4>
        @if (!empty($formSubtitle))
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $formSubtitle }}</p>
        @endif
    </div>
    <form method="POST" action="{{ $formAction }}" @if(!empty($enctype)) enctype="{{ $enctype }}" @endif class="p-6 space-y-6">
        @csrf
        @if (!empty($formMethod)) @method($formMethod) @endif