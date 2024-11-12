<div class="bg-white p-3 rounded shadow-lg h-[32rem]">
    <div class="flex justify-center items-center mb-6">
        <i class="fas fa-tasks text-orange-500 mr-2"></i>
        <h2 class="font-semibold text-lg">Assigned Tasks</h2>
    </div>
    
    <div class="overflow-x-auto">
        <ul class="flex space-x-4">
            @forelse($tasks as $task)
                <li class="bg-gray-50 p-4 rounded shadow flex flex-col min-w-[300px] h-[24rem]">
                    <!-- Task Title and Description -->
                    <div class="flex flex-col flex-1">
                        <p class="font-semibold text-lg text-orange-600">{{ $task->name }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ $task->description }}</p>
                        
                        <!-- Task Information: Project, Deadline, Assigned To -->
                        <div class="mt-auto">
                            @if($task->project)
                                <p class="text-gray-700"><strong>Project:</strong> <span class="text-gray-500 text-sm">{{ $task->project->name }}</span></p>
                            @endif

                            <p class="text-gray-700 text-md">
                                <strong>Deadline:</strong>
                               <span class="text-gray-500 text-sm">{{ $task->end_date ? \Carbon\Carbon::parse($task->end_date)->format('d M Y') : 'No deadline set' }}</span>
                            </p>

                            <p class="text-gray-700"><strong>Assigned To:</strong></p>
                            <div class="flex items-center mt-1">
                                <img src="{{ asset('storage/' . $task->employee->user->image) }}" alt="Assignee Image" class="w-8 h-8 rounded-full border-2 border-gray-300">
                                <span class="ml-2 text-gray-500 text-sm">{{ $task->employee->user->name }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Team Members (if any) -->
                    @if($task->relatedTasks && $task->relatedTasks->count() > 0)
                        <div class="mt-4">
                            <p class="text-gray-700"><strong>Collaborators:</strong></p>
                            <div class="flex -space-x-2 mt-1">
                                @foreach($task->relatedTasks->unique('employee.id') as $relatedTask)
                                    <img src="{{ asset('storage/' . $relatedTask->employee->user->image) }}" alt="{{ $relatedTask->employee->name }}" title="{{ $relatedTask->employee->name }}" class="w-8 h-8 rounded-full border-2 border-gray-300">
                                @endforeach
                                @if($task->relatedTasks->unique('employee.id')->count() > 5)
                                    <span class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs">+{{ $task->relatedTasks->unique('employee.id')->count() - 5 }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- View Task Button at the bottom -->
                    <div class="flex justify-center mt-4">
                        <a href="{{ route('tasks.show', $task->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-full text-center">View Task</a>
                    </div>
                </li>
            @empty
                <!-- Message when no tasks are assigned -->
                <div class="flex flex-col items-center justify-center w-full h-[24rem] text-center bg-gray-50 rounded p-6">
                    <p class="text-gray-500 mb-4">You currently have no tasks assigned. Please wait for the project manager to assign a task to you.</p>
                </div>
            @endforelse
        </ul>
    </div>
</div>
