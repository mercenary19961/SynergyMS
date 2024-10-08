@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <!-- Header Row -->
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-semibold">Add New Department</h1>
            <a href="{{ route('admin.departments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Create Form -->
        <form action="{{ route('admin.departments.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Department Name</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('name') }}" required>
            </div>
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">{{ old('description') }}</textarea>
            </div>
            <div>
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Create Department
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
