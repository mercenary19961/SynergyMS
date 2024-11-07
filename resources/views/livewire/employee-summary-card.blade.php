<div wire:poll.{{ $pollingInterval }}="refreshCount" class="bg-white p-6 rounded shadow text-center transition-transform transform hover:scale-105">
    <i class="{{ $icon }} fa-2x text-orange-500 mb-2"></i>
    <div class="text-4xl font-bold text-orange-500 mb-2">{{ $count }}</div>
    <p class="text-sm font-semibold text-gray-600">{{ $title }}</p>
</div>
