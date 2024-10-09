<div class="mt-6 flex justify-between items-center">
    <button type="{{ $type ?? 'submit' }}" class="{{ $class ?? 'bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center' }}">
        <i class="{{ $icon ?? 'fas fa-save mr-2' }}"></i> {{ $label }}
    </button>
</div>