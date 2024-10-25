<div class="relative mb-4">
    <label for="priority" class="block text-sm font-bold text-gray-700">
        <i class="fas fa-exclamation-triangle mr-2 text-orange-500"></i> Priority
    </label>
    
    <button wire:click="togglePriorityDropdown" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
        <span class="block truncate">{{ $selectedPriority ?? 'Select Priority' }}</span>
        <span class="flex items-center">
            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </span>
    </button>

    @if($openPriority)
        <ul wire:click.away="togglePriorityDropdown" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
            <li wire:click="selectPriority('Low')" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-exclamation-circle mr-2 text-orange-500 group-hover:text-white"></i> Low
            </li>
            <li wire:click="selectPriority('Medium')" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-minus mr-2 text-orange-500 group-hover:text-white"></i> Medium
            </li>
            <li wire:click="selectPriority('High')" class="cursor-pointer group select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center">
                <i class="fas fa-exclamation-triangle mr-2 text-orange-500 group-hover:text-white"></i> High
            </li>
        </ul>
    @endif

    <input type="hidden" name="priority" value="{{ $selectedPriority }}">
    @error('priority')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
