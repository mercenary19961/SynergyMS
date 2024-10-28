<div>
    @if($showMessage)
        <div class="fixed inset-0 flex items-center justify-center z-50">
            <div class="bg-white border border-gray-300 rounded-lg shadow-lg p-6 max-w-sm text-center">
                <p class="text-gray-700 font-semibold">{{ $messageText }}</p>
                <button wire:click="closePopup" class="mt-4 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                    OK
                </button>
            </div>
        </div>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 z-80"></div>
    @endif
</div>
