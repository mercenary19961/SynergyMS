{{-- resources/views/admin/clients/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    @include('partials.sidebar')

    <div class="flex-1 p-6 bg-gray-100">
        <h1 class="mb-4 text-2xl font-semibold">Add New Client</h1>

        <!-- Error Message -->
        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">There were some problems with your input.</span>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 text-red-700 focus:outline-none">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('admin.clients.store') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Two-column Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- User Dropdown with Alpine.js -->
                <div x-data="{ open: false, selected: '{{ old('user_id') ?? 'Select a User' }}' }" class="relative">
                    <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                    <button @click="open = !open" type="button" class="mt-1 w-full bg-white border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500">
                        <span x-text="selected"></span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>
                    </button>
                    <ul x-show="open" @click.away="open = false" class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none">
                        @foreach($users as $user)
                            <li @click="selected = '{{ $user->name }}'; $refs.user_id.value = '{{ $user->id }}'; open = false" class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white">
                                <span class="font-normal">{{ $user->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <input type="hidden" name="user_id" x-ref="user_id" :value="selected === 'Select a User' ? '' : selected">
                </div>

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-gray-700">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('company_name') }}" placeholder="Enter company name" required>
                </div>

                <!-- Industry -->
                <div>
                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                    <input type="text" name="industry" id="industry" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('industry') }}" placeholder="Enter industry" required>
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('contact_number') }}" placeholder="Enter contact number" required>
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('address') }}" placeholder="Enter address" required>
                </div>

                <!-- Website -->
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" name="website" id="website" class="mt-1 block w-full border border-gray-300 focus:border-orange-500 focus:outline-none rounded-md p-2" value="{{ old('website') }}" placeholder="Enter website URL" required>
                </div>
            </div>

            <!-- Submit Button and Back Button on the Same Row -->
            <div class="mt-6 flex justify-between items-center">
                <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition inline-flex items-center">
                    <i class="fas fa-save mr-2"></i> Add Client
                </button>
                <a href="{{ route('admin.clients.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
