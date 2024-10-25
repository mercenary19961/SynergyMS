@extends('layouts.app')

@section('content')
<div class="flex flex-col h-screen">
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Edit Ticket" />

        @include('components.form.errors')

        <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST" x-data="ticketForm()">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Ticket Issuer (User) Name and ID -->
                <div class="mb-4">
                    <label for="user_name" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-user mr-1"></i> Ticket Issuer
                    </label>
                    <!-- Display the name in a read-only field -->
                    <input type="text" id="user_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none bg-gray-100" value="{{ $ticket->user->name }}" readonly>

                    <!-- Hidden input to hold the user ID -->
                    <input type="hidden" name="user_id" value="{{ $ticket->user_id }}">
                    @error('user_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-file-alt mr-1"></i> Title
                    </label>
                    <input type="text" name="title" id="title" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" value="{{ old('title', $ticket->title) }}" placeholder="Enter Ticket Title">
                    @error('title')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-align-left mr-1"></i> Description
                    </label>
                    <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none">{{ old('description', $ticket->description) }}"></textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Dropdown -->
                <div class="relative mb-4">
                    <label for="priority" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Priority
                    </label>
                    <button type="button" @click="openPriority = !openPriority" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedPriority || 'Select Priority'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a 1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openPriority" @click.away="openPriority = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        <li @click="selectedPriority = 'High'; $refs.priority.value = 'High'; openPriority = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-exclamation-triangle text-orange-500 group-hover:text-white"></i> High
                        </li>
                        <li @click="selectedPriority = 'Medium'; $refs.priority.value = 'Medium'; openPriority = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-minus text-orange-500 group-hover:text-white"></i> Medium
                        </li>
                        <li @click="selectedPriority = 'Low'; $refs.priority.value = 'Low'; openPriority = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group">
                            <i class="fas fa-exclamation-circle text-orange-500 group-hover:text-white"></i> Low
                        </li>
                    </ul>
                    <input type="hidden" name="priority" x-ref="priority" value="{{ old('priority', $ticket->priority) }}">
                    @error('priority')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Assigned Employee Dropdown -->
                <div class="relative mb-4">
                    <label for="employee_id" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-user mr-1"></i> Assigned Employee
                    </label>
                    <button type="button" @click="openEmployee = !openEmployee" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-3 py-2 flex items-center justify-between focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span class="block truncate" x-text="selectedEmployee || 'Select Employee'"></span>
                        <span class="flex items-center">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a 1 1 0 111.414 1.414l-4 4a 1 1 0 01-1.414 0l-4-4a 1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <ul x-show="openEmployee" @click.away="openEmployee = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
                        @foreach($employees as $employee)
                            <li @click="selectedEmployee = '{{ $employee->user->name }}'; $refs.employee_id.value = '{{ $employee->id }}'; updateProjectManager('{{ $employee->projectManager->user->name }}', '{{ $employee->projectManager->id }}'); openEmployee = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white group flex items-center">
                                <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> {{ $employee->user->name }}
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="employee_id" x-ref="employee_id" value="{{ old('employee_id', $ticket->employee_id) }}">
                    @error('employee_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Project Manager - Auto updated based on the Employee -->
                <div class="relative mb-4">
                    <label for="project_manager_id" class="block text-sm font-bold text-gray-700">
                        <i class="fas fa-user-tie mr-1"></i> Project Manager
                    </label>
                    <div class="border p-3 bg-white rounded-lg shadow-md flex items-center">
                        <i class="fas fa-user-circle mr-2 text-gray-400"></i>
                        <input type="text" disabled x-bind:value="selectedProjectManager" class="flex-grow border-none bg-transparent text-gray-600" placeholder="Project Manager will be updated based on Employee">
                    </div>
                    <input type="hidden" name="project_manager_id" x-ref="project_manager_id" value="{{ old('project_manager_id', $ticket->project_manager_id) }}">
                    @error('project_manager_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <x-form.button-submit label="Update Ticket" />
        </form>
    </div>
    <x-footer />
</div>

<script>
function ticketForm() {
    return {
        openEmployee: false,
        openPriority: false,
        selectedEmployee: '{{ old('employee_id', $ticket->employee ? $ticket->employee->user->name : '') }}',
        selectedProjectManager: '{{ old('project_manager_id', $ticket->projectManager ? $ticket->projectManager->user->name : '') }}',
        selectedPriority: '{{ old('priority', $ticket->priority) }}',
        updateProjectManager(managerName, managerId) {
            this.selectedProjectManager = managerName;
            this.$refs.project_manager_id.value = managerId;
        }
    }
}

</script>

@endsection
