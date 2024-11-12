<div class="flex justify-between items-center mb-4">
    <div class="flex items-center">
        @if(isset($icon))
            <i class="{{ $icon }} text-gray-500 mr-2"></i>
        @endif
        <h1 class="text-2xl font-semibold text-gray-800">{{ $title ?? 'Default Title' }}</h1>
    </div>
    <x-back-button :route="$route ?? null" />
</div>
