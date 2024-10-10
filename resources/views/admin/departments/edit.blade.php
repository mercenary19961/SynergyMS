@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">
        <x-title-with-back title="Edit Department" />

        @include('components.form.errors')

        <!-- Edit Form -->
        <form action="{{ route('admin.departments.update', $department->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Department Name</label>
                <input type="text" name="name" id="name" value="{{ $department->name }}" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2">{{ $department->description }}</textarea>
            </div>

            <x-form.button-submit label="Update Department" />
        </form>
    </div>
</div>
@endsection
