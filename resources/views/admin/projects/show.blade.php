@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen" x-data="projectPage">
    <div class="flex-1 p-6 bg-gray-100">

        <!-- Title with Icon, Buttons, and Back Button -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-3xl font-bold text-gray-700 flex items-center">
                <i class="fas fa-project-diagram mr-2 text-orange-500"></i> Project Details
            </h2>
            
            <!-- Button Group for Add Task, Edit Project, and Back -->
            <div class="flex space-x-4">
                <!-- Add Task Button (visible only to the Project Manager) -->
                @if(auth()->user()->id === $project->projectManager->user->id || auth()->user()->hasRole('Super Admin'))
                    <button @click="showAddTaskModal = true" class="bg-pink-600 text-white px-4 py-2 rounded hover:bg-pink-700 transition">
                        <i class="fas fa-plus mr-1"></i> Add Task
                    </button>
                
                
                    <!-- Edit Project Button (visible to all users) -->
                    <button @click="showEditProjectModal = true" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                        <i class="fas fa-edit mr-1"></i> Edit Status
                    </button>
                @endif
                
                <!-- Back Button -->
                <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </div>

        <!-- Project Details and Tasks -->
        <div class="flex flex-col lg:flex-row gap-4">

            <!-- Project Info Section -->
            <div class="flex flex-col bg-white shadow-lg rounded-lg p-6 w-full lg:w-1/2">
                <h2 class="text-2xl font-bold text-orange-500 mb-4">
                    <i class="fas fa-project-diagram mr-2"></i> {{ $project->name }}
                </h2>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <!-- Department -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-building text-gray-700 mr-1"></i> Department
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->department->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Client -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-handshake text-gray-700 mr-1"></i> Client
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->client->company_name ?? 'N/A' }}</p>
                    </div>

                    <!-- Status -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-tasks text-gray-700 mr-1"></i> Status
                        </p>
                        <p class="mt-1 text-sm font-semibold 
                        @if($project->status == 'Pending') text-orange-500 
                        @elseif($project->status == 'In Progress') text-yellow-500 
                        @elseif($project->status == 'Completed') text-green-500 
                        @else text-gray-500 @endif">
                        {{ $project->status }}</p>
                    </div>

                    <!-- Start Date -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> Start Date
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <!-- End Date -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-gray-700 mr-1"></i> End Date
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->end_date ? $project->end_date->format('M d, Y') : 'N/A' }}</p>
                    </div>

                    <!-- Project Manager -->
                    <div>
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-user-tie text-gray-700 mr-1"></i> Project Manager
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->projectManager->user->name ?? 'N/A' }}</p>
                    </div>

                    <!-- Description -->
                    <div class="lg:col-span-2">
                        <p class="text-sm font-semibold text-gray-700">
                            <i class="fas fa-align-left text-gray-700 mr-1"></i> Description
                        </p>
                        <p class="mt-1 text-sm text-gray-600">{{ $project->description ?? 'No description available' }}</p>
                    </div>
                </div>
            </div>

            <!-- Tasks Section -->
            <div class="flex flex-col bg-white shadow-lg rounded-lg p-6 w-full lg:w-1/2">
                <h2 class="text-2xl font-bold text-orange-500 mb-4">
                    <i class="fas fa-tasks mr-2"></i> Tasks
                </h2>
                @if($project->tasks->isEmpty())
                    <p class="text-sm text-gray-600">No tasks available for this project.</p>
                @else
                    <!-- Scrollable container for tasks -->
                    <div class="space-y-4 overflow-y-auto" style="max-height: 500px;">
                        @foreach($project->tasks as $task)
                            <div class="p-4 border border-gray-300 rounded-md bg-gray-50">
                                <p class="text-sm font-semibold text-gray-700">{{ $task->name }}</p>
                                <p class="text-xs text-gray-500">Assigned To: 
                                    <span class="font-medium text-gray-700">{{ $task->employee->user->name ?? 'N/A' }}</span>
                                </p>
                                <p class="text-xs text-gray-500">Status: 
                                    <span class="font-medium 
                                        @if($task->status == 'Pending') text-orange-500 
                                        @elseif($task->status == 'In Progress') text-yellow-500 
                                        @elseif($task->status == 'Completed') text-green-500 
                                        @else text-gray-500 @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </p>
                                <p class="text-xs text-gray-500">Priority: 
                                    <span class="font-medium 
                                        @if($task->priority == 'High') text-red-500 
                                        @elseif($task->priority == 'Medium') text-yellow-500 
                                        @elseif($task->priority == 'Low') text-green-500 
                                        @else text-gray-500 @endif">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </p>
                                @if(auth()->user()->id === $project->projectManager->user->id || auth()->user()->hasRole('Super Admin'))
                                    <!-- Edit Task Button -->
                                    <button @click="openEditTaskModal({{ $task->id }})" 
                                            class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition text-sm mt-2">
                                        <i class="fas fa-edit mr-1"></i> Edit Task
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
    <x-footer />
    <!-- Add Task Modal -->
    <div x-show="showAddTaskModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="text-center sm:text-left">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">Add New Task</h3>
                    <form action="{{ route('tasks.store') }}" method="POST" class="mt-4">
                        @csrf
                        <input type="hidden" name="project_id" value="{{ $project->id }}">
                        
                        <!-- Task Name -->
                        <div class="mb-4">
                            <label for="task_name" class="block text-sm font-bold text-gray-700">
                                Task Name
                            </label>
                            <input type="text" name="name" id="task_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                        </div>

                        <!-- Employee Dropdown -->
                        <div class="mb-4">
                            <label for="employee_id" class="block text-sm font-bold text-gray-700">
                                Assign To
                            </label>
                            <select name="employee_id" id="employee_id" class="block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Priority Dropdown -->
                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-bold text-gray-700">
                                Priority
                            </label>
                            <select name="priority" id="priority" class="block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>

                        <!-- Description Field -->
                        <div class="mb-4">
                            <label for="description" class="block text-sm font-bold text-gray-700">
                                Description
                            </label>
                            <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500" required></textarea>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="showAddTaskModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                            <button type="submit" class="ml-2 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Create Task</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Project Modal -->
    <div x-show="showEditProjectModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="text-center sm:text-left">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">Edit Project</h3>
                    <form action="{{ route('admin.projects.update', $project->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <!-- Project Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-bold text-gray-700">
                                Project Status
                            </label>
                            <select name="status" id="status" class="block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500">
                                <option value="Pending" @if($project->status == 'Pending') selected @endif>Pending</option>
                                <option value="In Progress" @if($project->status == 'In Progress') selected @endif>In Progress</option>
                                <option value="Completed" @if($project->status == 'Completed') selected @endif>Completed</option>
                            </select>
                        </div>

                        <!-- End Date -->
                        <div class="mb-4">
                            <label for="end_date" class="block text-sm font-bold text-gray-700">
                                End Date
                            </label>
                            <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500" value="{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}">
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="showEditProjectModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                            <button type="submit" class="ml-2 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <div x-show="showEditTaskModal" class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="text-center sm:text-left">
                    <h3 class="text-lg font-medium text-gray-900" id="modal-title">Edit Task</h3>
                    <form :action="'{{ url('/admin/tasks/update') }}/' + selectedTaskId" method="POST" class="mt-4">
                        @csrf
                        @method('PUT')

                        <!-- Task Name -->
                        <div class="mb-4">
                            <label for="task_name" class="block text-sm font-bold text-gray-700">Task Name</label>
                            <input type="text" name="name" id="task_name" x-model="taskName" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" required>
                        </div>

                        <!-- Employee Dropdown -->
                        <div class="mb-4">
                            <label for="employee_id" class="block text-sm font-bold text-gray-700">Assign To</label>
                            <select name="employee_id" id="employee_id" x-model="assignedEmployee" class="block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500">
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-bold text-gray-700">Status</label>
                            <select name="status" id="status" x-model="status" class="block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500">
                                <option value="Pending">Pending</option>
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <!-- Priority Dropdown -->
                        <div class="mb-4">
                            <label for="priority" class="block text-sm font-bold text-gray-700">Priority</label>
                            <select name="priority" id="priority" x-model="priority" class="block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500">
                                <option value="High">High</option>
                                <option value="Medium">Medium</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>

                        <!-- Submit and Cancel Buttons -->
                        <div class="flex justify-end mt-4">
                            <button type="button" @click="closeEditTaskModal" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">Cancel</button>
                            <button type="submit" class="ml-2 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('projectPage', () => ({
            showAddTaskModal: false,
            showEditProjectModal: false,
            showEditTaskModal: false,
            selectedTaskId: null,
            taskName: '',
            assignedEmployee: '',
            status: '',
            priority: '',

            // Function to open the Edit Task modal with task data
            async openEditTaskModal(taskId) {
                try {
                    // Fetch the latest task data from the server
                    const response = await fetch(`/admin/tasks/${taskId}`);
                    if (!response.ok) {
                        throw new Error("Failed to fetch task data.");
                    }

                    const task = await response.json();

                    // Update Alpine.js data with the fetched task information
                    this.selectedTaskId = task.id;
                    this.taskName = task.name;
                    this.assignedEmployee = task.employee_id;
                    this.status = task.status;
                    this.priority = task.priority;

                    this.showEditTaskModal = true;
                } catch (error) {
                    console.error("Error fetching task data:", error);
                }
            },

            // Function to close the Edit Task modal
            closeEditTaskModal() {
                this.selectedTaskId = null;
                this.taskName = '';
                this.assignedEmployee = '';
                this.status = '';
                this.priority = '';
                this.showEditTaskModal = false;
            }
        }));
    });
</script>


@endsection