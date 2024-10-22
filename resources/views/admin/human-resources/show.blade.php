@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white p-6 rounded-lg shadow-lg space-y-6 relative text-sm">
        <!-- Title Section -->
        <x-title-with-back title="{{ $humanResource->user->name }} Details" />

        <!-- HR Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-600">
            <!-- Left Column: HR Information -->
            <div class="space-y-4">
                <div>
                    <h2 class="text-xl font-semibold text-orange-600 mb-2">
                        <i class="fas fa-info-circle mr-2"></i>Human Resources Information
                    </h2>
                    <p class="mb-2"><strong><i class="fas fa-building mr-2"></i>Department:</strong> {{ $humanResource->department->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong><i class="fas fa-briefcase mr-2"></i>Position:</strong> {{ $humanResource->position->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong><i class="fas fa-phone-alt mr-2"></i>Contact Number:</strong> {{ $humanResource->contact_number }}</p>
                    <p><strong><i class="fas fa-envelope mr-2"></i>Company Email:</strong> {{ $humanResource->company_email }}</p>
                </div>
            </div>

            <!-- Right Column: User Image -->
            <div class="flex justify-center md:justify-start">
                @if($humanResource->user && $humanResource->user->image)
                    <img 
                        src="{{ asset('storage/' . $humanResource->user->image) }}" 
                        alt="{{ $humanResource->user->name }}" 
                        class="rounded-full h-64 w-64 object-cover shadow-md"
                    >
                @else
                    <img 
                        src="{{ asset('images/default_user_image.png') }}" 
                        alt="{{ $humanResource->user->name }}" 
                        class="rounded-full h-32 w-32 object-cover shadow-md"
                    >
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-6">
            <a href="{{ route('admin.human-resources.edit', $humanResource->id) }}" class="btn bg-orange-500 text-white hover:bg-orange-600 py-2 px-4 rounded">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>
</div>
@endsection
