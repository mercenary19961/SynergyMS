{{-- usage example <x-back-button route="admin.tickets.index" /> --}}
<a href="{{ $route ? route($route) : url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
    <i class="fas fa-arrow-left mr-2"></i> {{ $text?? 'Back'}}
</a>
