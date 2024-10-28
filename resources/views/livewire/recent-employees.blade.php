<div wire:poll.{{ $pollingInterval }}="refreshRecentEmployees" class="bg-white p-6 rounded shadow flex flex-col h-full">
    <i class="fas fa-user-plus fa-2x text-orange-500 mb-2"></i>
    <h2 class="text-xl font-semibold mb-4">Recent Employees</h2>
    
    <ul class="text-sm flex-grow">
        @foreach ($recentEmployees as $employee)
            <li class="mb-4">
                <!-- Employee Item -->
                <a href="{{ route('admin.employees.show', $employee->id) }}" class="flex items-center justify-between space-x-4 w-full text-left focus:outline-none transition-transform transform hover:scale-105 p-2 rounded transition">
                    <!-- Employee Image -->
                    <img src="{{ $employee->user->image ? asset('storage/' . $employee->user->image) : asset('default-avatar.png') }}" 
                         alt="{{ $employee->user->name }}" 
                         class="w-10 h-10 rounded-full object-cover">

                    <!-- Employee Name and Join Date -->
                    <div class="flex-grow">
                        <span class="truncate block font-semibold text-gray-600">
                            {{ Str::limit($employee->user->name, 30) }}
                        </span>
                    </div>

                    <!-- Joined Date (on the far right) -->
                    <span class="text-gray-500 text-xxs whitespace-nowrap px-2">
                        (Joined {{ $employee->created_at->diffForHumans() }})
                    </span>
                </a>
                <!-- Divider -->
                <hr class="my-1 border-gray-300">
            </li>
        @endforeach
    </ul>
    
    <a href="{{ route('admin.employees.index') }}" class="block bg-orange-500 text-white text-center py-2 rounded mt-4">
        View All Employees
    </a>
</div>
