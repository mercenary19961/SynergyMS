{{-- resources/views/admin/departments/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Departments</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add New Department Button -->
        <a href="{{ route('admin.departments.create') }}" class="btn btn-primary mb-3">Add New Department</a>

        <!-- Departments Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">Department Name</th>
                        <th class="py-2 px-4 text-left">Description</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($departments as $department)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $department->id }}</td>
                            <td class="py-2 px-4">{{ $department->name }}</td>
                            <td class="py-2 px-4">{{ $department->description }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.departments.edit', $department->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
