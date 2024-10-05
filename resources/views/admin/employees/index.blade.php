{{-- resources/views/admin/employees/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Employees</h1>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Add New Employee Button -->
        <a href="{{ route('admin.employees.create') }}" class="btn btn-primary mb-3">Add New Employee</a>

        <!-- Employees Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="py-2 px-4 text-left">#</th>
                        <th class="py-2 px-4 text-left">User Name</th>
                        <th class="py-2 px-4 text-left">Position</th>
                        <th class="py-2 px-4 text-left">Department</th>
                        <th class="py-2 px-4 text-left">Salary</th>
                        <th class="py-2 px-4 text-left">Date of Joining</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                        <tr class="border-t">
                            <td class="py-2 px-4">{{ $employee->id }}</td>
                            <td class="py-2 px-4">{{ $employee->user->name }}</td>
                            <td class="py-2 px-4">{{ $employee->position }}</td>
                            <td class="py-2 px-4">{{ $employee->department->name }}</td>
                            <td class="py-2 px-4">{{ $employee->salary }}</td>
                            <td class="py-2 px-4">{{ $employee->date_of_joining }}</td>
                            <td class="py-2 px-4">
                                <a href="{{ route('admin.employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" style="display:inline-block;">
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
