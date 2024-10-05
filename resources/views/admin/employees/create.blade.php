{{-- resources/views/admin/employees/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <div class="flex-1 p-6 bg-gray-100">

        <h1 class="mb-4 text-2xl font-semibold">Create New Employee</h1>

        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf

            <!-- User ID -->
            <div class="mb-3">
                <label for="user_id" class="form-label">User</label>
                <input type="text" name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}">
                @error('user_id')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Position -->
            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}">
                @error('position')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Other fields... -->

            <button type="submit" class="btn btn-success">Create Employee</button>
        </form>
    </div>
</div>
@endsection
