@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        @include('components.form.success')

        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Departments</h1>
        
            <a href="{{ route('admin.departments.create') }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                <i class="fas fa-plus-circle mr-2"></i> Add New Department
            </a>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left text-sm">#</th>
                        <th class="py-2 px-4 text-left text-sm">Department Name</th>
                        <th class="py-2 px-4 text-left text-sm">Description</th>
                        <th class="py-2 px-4 text-left text-sm">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $index => $department)
                        <tr class="{{ $index % 2 == 1 ? 'bg-gray-100' : 'bg-white' }} border-t">
                            <td class="py-2 px-4 text-sm">{{ $department->id }}</td>
                            <td class="py-2 px-4 text-sm">{{ $department->name }}</td>
                            <td class="py-2 px-4 text-sm">{{ $department->description }}</td>
                            <td class="py-2 px-4 text-sm flex space-x-4">
                                <a href="{{ route('admin.departments.show', $department->id) }}" class="transform hover:text-blue-500 hover:scale-110">
                                    <i class="fas fa-eye fa-md"></i>
                                </a>
                                <a href="{{ route('admin.departments.edit', $department->id) }}" class="transform hover:text-orange-500 hover:scale-110">
                                    <i class="fas fa-pen fa-md"></i>
                                </a>
                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="w-4 ml-2 transform hover:text-red-500 hover:scale-110 delete-btn">
                                        <i class="fas fa-trash fa-md"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $departments->links('pagination::tailwind') }}
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
