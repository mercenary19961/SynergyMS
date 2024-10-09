@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Flex container for h1 and button -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Project Managers</h1>
            <!-- Add New Project Manager Button on the far right -->
            <a href="{{ route('admin.project-managers.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                <i class="fas fa-plus mr-2"></i>Add New Project Manager
            </a>
        </div>

        @include('components.form.success')

        <!-- Project Managers Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-200 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">#</th>
                        <th class="py-3 px-6 text-left">User Name</th>
                        <th class="py-3 px-6 text-left">Department</th>
                        <th class="py-3 px-6 text-left">Experience Years</th>
                        <th class="py-3 px-6 text-left">Contact Number</th>
                        <th class="py-3 px-6 text-left">Assigned Projects</th>
                        <th class="py-3 px-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-black text-sm font-normal">
                    @foreach($projectManagers as $projectManager)
                        <tr class="border-b border-gray-200 hover:bg-gray-100 {{ $loop->iteration % 2 == 0 ? 'bg-gray-200' : '' }}">
                            <td class="py-3 px-6">{{ $projectManager->id }}</td>
                            <td class="py-3 px-6">{{ $projectManager->user->name }}</td>
                            <td class="py-3 px-6">{{ $projectManager->department->name }}</td>
                            <td class="py-3 px-6">{{ $projectManager->experience_years }}</td>
                            <td class="py-3 px-6">{{ $projectManager->contact_number }}</td>
                            <td class="py-3 px-6">{{ $projectManager->assigned_projects_count }}</td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex item-center justify-center space-x-4">
                                    <!-- Show Button -->
                                    <a href="{{ route('admin.project-managers.show', $projectManager->id) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-110">
                                        <i class="fas fa-eye fa-md"></i>
                                    </a>
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.project-managers.edit', $projectManager->id) }}" class="w-4 mr-2 transform hover:text-orange-500 hover:scale-110">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </a>
                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.project-managers.destroy', $projectManager->id) }}" method="POST" class="inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="w-4 ml-2 transform hover:text-red-500 hover:scale-110 delete-btn">
                                            <i class="fas fa-trash fa-md"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $projectManagers->links('pagination::tailwind') }} <!-- Use the Tailwind pagination style -->
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#737373',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection
