<!-- Gender Dropdown -->
<div x-data="{ open: false, selected: '{{ old('gender') ?? $projectManager->user->gender ?? 'Select Gender' }}' }" class="relative">
    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
        <span x-text="selected"></span>
        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
            <i class="fas fa-chevron-down text-orange-500 group-hover:text-white"></i>
        </span>
    </button>
    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
        <li @click="selected = 'Male'; $refs.gender.value = 'Male'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
            <span class="flex items-center">
                <i class="fas fa-male mr-2 text-orange-500 group-hover:text-white"></i> Male
            </span>
        </li>
        <li @click="selected = 'Female'; $refs.gender.value = 'Female'; open = false" class="group cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
            <span class="flex items-center">
                <i class="fas fa-female mr-2 text-orange-500 group-hover:text-white"></i> Female
            </span>
        </li>
    </ul>
    <input type="hidden" name="gender" x-ref="gender" :value="selected === 'Select Gender' ? '' : selected">
</div>
