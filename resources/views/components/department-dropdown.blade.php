<div x-data="{ 
    open: false, 
    selected: '{{ old('department_id') ? $departments->find(old('department_id'))->name : ($selectedDepartment->name ?? 'Select Department') }}' 
}" 
class="relative mb-4"
>
    <label for="department_id" class="block text-sm font-medium text-gray-700">
        <i class="fas fa-building mr-2"></i> Department
    </label>
    
    <!-- Button to open the dropdown -->
    <button 
        @click="open = !open" 
        type="button" 
        class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500"
    >
        <span x-text="selected" class="block truncate"></span>
        <span class="absolute inset-y-11 right-0 flex items-center pr-2 pointer-events-none">
            <i class="fas fa-chevron-down text-orange-500"></i>
        </span>
    </button>

    <!-- Dropdown options -->
    <ul 
        x-show="open" 
        @click.away="open = false" 
        class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none"
    >
        <!-- Default 'Select Department' option -->
        <li 
            @click="selected = 'Select Department'; $refs.department_id.value = ''; open = false" 
            class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
        >
            <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i> Select Department
        </li>
        
        <!-- Dynamic Department options -->
        @foreach($departments as $department)
            <li 
                @click="selected = '{{ $department->name }}'; $refs.department_id.value = '{{ $department->id }}'; open = false" 
                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group"
            >
                <!-- Icon logic -->
                @if($department->name == 'Software Development')
                    <i class="fas fa-code mr-2 text-orange-500 group-hover:text-white"></i>
                @elseif($department->name == 'Network Engineering')
                    <i class="fas fa-network-wired mr-2 text-orange-500 group-hover:text-white"></i>
                @elseif($department->name == 'Data Analysis')
                    <i class="fas fa-chart-bar mr-2 text-orange-500 group-hover:text-white"></i>
                @elseif($department->name == 'Technical Support')
                    <i class="fas fa-headset mr-2 text-orange-500 group-hover:text-white"></i>
                @elseif($department->name == 'Quality Assurance')
                    <i class="fas fa-check-circle mr-2 text-orange-500 group-hover:text-white"></i>
                @elseif($department->name == 'UX/UI')
                    <i class="fas fa-paint-brush mr-2 text-orange-500 group-hover:text-white"></i>
                @else
                    <i class="fas fa-building mr-2 text-orange-500 group-hover:text-white"></i>
                @endif
                {{ $department->name }}
            </li>
        @endforeach
    </ul>

    <!-- Hidden input to store the selected department ID for form submission -->
    <input type="hidden" name="department_id" x-ref="department_id" value="{{ old('department_id', $selectedDepartment->id ?? '') }}">
    
    @error('department_id')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>
