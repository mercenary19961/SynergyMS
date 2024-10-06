@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Edit Project Manager</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.project-managers.update', $projectManager->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- User Selection -->
            <div>
                <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                <select name="user_id" id="user_id" required class="w-full px-3 py-2 border rounded-md">
                    <option value="" disabled>Select a User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $projectManager->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Department Selection -->
            <div class="mt-4">
                <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                <select name="department_id" id="department_id" required class="w-full px-3 py-2 border rounded-md">
                    <option value="" disabled>Select a Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $projectManager->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Experience Years -->
            <div class="mt-4">
                <label for="experience_years" class="block text-sm font-medium text-gray-700">Experience Years</label>
                <input type="number" name="experience_years" id="experience_years" value="{{ old('experience_years', $projectManager->experience_years) }}" required class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Contact Number -->
            <div class="mt-4">
                <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number', $projectManager->contact_number) }}" required class="w-full px-3 py-2 border rounded-md">
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded-md">Update Project Manager</button>
            </div>
        </form>
    </div>
</div>
@endsection
