<div wire:poll.{{ $pollingInterval }}="refreshAbsentEmployees" class="bg-white p-6 mb-5 rounded shadow flex flex-col h-full">
    <div class="flex flex-row justify-start">
        <i class="fas fa-user-times fa-2x text-orange-500 mb-2"></i>
        <h2 class="text-xl font-semibold mb-4 ml-4">Absent Employees</h2>
    </div>

    <!-- Scrollable list with fixed height and overflow-y -->
    <ul class="text-sm flex-grow overflow-y-auto" style="max-height: 300px;">
        @foreach ($absentEmployees as $attendance)
            <li class="mb-4">
                <button wire:click="showAbsentEmployeeDetails({{ $attendance->employee->id }})" class="w-full transition-transform transform hover:scale-105 text-left focus:outline-none p-3" title="{{ $attendance->employee->user->name }}">
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
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex justify-center items-center z-50" wire:ignore.self>
        <div class="bg-white rounded-lg w-1/3 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">{{ $selectedAbsentEmployee->employee->user->name }}</h3>
                <button wire:click="closeAbsentEmployeeDetails" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Absent Employee Details Modal -->
            <div class="text-sm">
                <div class="mb-2">
                    <strong>Department:</strong> {{ $selectedAbsentEmployee->employee->department->name ?? 'N/A' }}
                </div>
                <div class="mb-2">
                    <strong>Position:</strong> {{ $selectedAbsentEmployee->employee->position->name ?? 'N/A' }}
                </div>

                <!-- Tasks List -->
                <div>
                    <strong>Tasks:</strong>
                    <div class="mt-2 space-y-1">
                        @if ($selectedAbsentEmployee && $selectedAbsentEmployee->employee->tasks->isNotEmpty())
                            @foreach ($selectedAbsentEmployee->employee->tasks as $task)
                                <a href="{{ route('admin.projects.show', $task->project->id) }}" class="flex justify-between items-center bg-gray-100 p-2 rounded text-xs transition-transform transform hover:scale-105" title="View Project">
                                    <span class="truncate">
                                        {{ Str::limit($task->name, 20) }} - {{ $task->status }}
                                    </span>
                                    <span class="text-gray-600 text-right text-xs">
                                        Project: {{ $task->project->name ?? 'No Project' }}
                                    </span>
                                </a>
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
