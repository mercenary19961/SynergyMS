<div wire:poll.{{ $pollingInterval }}="refreshAbsentEmployees" class="bg-white p-6 mb-5 rounded shadow flex flex-col h-full">
    <i class="fas fa-user-times fa-2x text-orange-500 mb-2"></i>
    <h2 class="text-xl font-semibold mb-4">Absent Employees</h2>

    <!-- Scrollable list with fixed height and overflow-y -->
    <ul class="text-sm flex-grow overflow-y-auto" style="max-height: 300px;">
        @foreach ($absentEmployees as $attendance)
            <li class="mb-4">
                <button wire:click="showAbsentEmployeeDetails({{ $attendance->employee->id }})" class="w-full hover:bg-gray-100 text-left focus:outline-none p-3" title="{{ $attendance->employee->user->name }}">
                    <div class="flex items-center justify-between space-x-4">
                        <!-- Employee Image -->
                        <img src="{{ $attendance->employee->user->image ? asset('storage/' . $attendance->employee->user->image) : asset('default-avatar.png') }}" 
                             alt="{{ $attendance->employee->user->name }}" 
                             class="w-10 h-10 rounded-full object-cover">

                        <!-- Employee Name and Department -->
                        <div class="flex-grow">
                            <span class="truncate block font-semibold text-gray-600">
                                {{ Str::limit($attendance->employee->user->name, 30) }}
                            </span>
                            <!-- Department Name -->
                            <span class="text-gray-500 text-xs">
                                Department: {{ $attendance->employee->department->name ?? 'N/A' }}
                            </span>
                        </div>

                        <!-- Absent Date (on the far right) -->
                        <span class="text-gray-500 text-xxs whitespace-nowrap px-2">
                            Absent on {{ \Carbon\Carbon::parse($attendance->attendance_date)->format('D M Y') }}
                        </span>
                    </div>
                </button>

                <!-- Divider -->
                <hr class="my-1 border-gray-300">
            </li>
        @endforeach
    </ul>

    <!-- Modal -->
    @if($selectedAbsentEmployee)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex justify-center items-center" wire:ignore.self>
        <div class="bg-white rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">{{ $selectedAbsentEmployee->employee->user->name }}</h3>
                <button wire:click="closeAbsentEmployeeDetails" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Department, Position, and Projects -->
            <div class="text-sm">
                <div class="mb-2">
                    <strong>Department:</strong> {{ $selectedAbsentEmployee->employee->department->name ?? 'N/A' }}
                </div>
                <div class="mb-2">
                    <strong>Position:</strong> {{ $selectedAbsentEmployee->employee->position->name ?? 'N/A' }}
                </div>

                <!-- Projects List -->
                <div>
                    <strong>Projects:</strong>
                    <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-1">
                        @if ($selectedAbsentEmployee->employee->projects->isNotEmpty())
                            @foreach ($selectedAbsentEmployee->employee->projects as $project)
                                <div class="bg-gray-100 p-2 rounded text-xs truncate" title="{{ $project->name }}">
                                    {{ Str::limit($project->name, 20) }}
                                </div>
                            @endforeach
                        @else
                            <div class="text-xs text-gray-500">N/A</div>
                        @endif
                    </div>
                </div>

                <!-- View Employee Button -->
                <a href="{{ route('admin.employees.show', $selectedAbsentEmployee->employee->id) }}" class="block mt-4 bg-orange-500 text-white text-center py-2 rounded hover:bg-orange-600 transition">
                    View Employee
                </a>
            </div>
        </div>
    </div>
    @endif
</div>
