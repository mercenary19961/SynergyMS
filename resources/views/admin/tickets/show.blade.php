@extends('layouts.app')

@section('content')
<div class="flex h-screen">
    <div class="flex-1 p-6 bg-gray-100 overflow-auto">
        <x-title-with-back title="Ticket Details" route="admin.tickets.index" />

        <div class="bg-white shadow-lg rounded-lg p-6 max-w-3xl mx-auto text-gray-700">
            <h2 class="text-xl font-semibold mb-4 border-b pb-2"><i class="fas fa-info-circle mr-2 "></i> Ticket Information</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fas fa-hashtag mr-1 "></i> Ticket ID Number:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->id }}</p>
                </div>
                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-file-alt mr-1 "></i> Title:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->title }}</p>
                </div>

                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-info-circle mr-1"></i> Status:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->status }}</p>
                </div>

                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-exclamation-triangle mr-1"></i> Priority:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->priority }}</p>
                </div>

                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-user mr-1"></i> Employee:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->employee->user->name ?? 'Not Assigned' }}</p>
                </div>

                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-user-tie mr-1"></i> Project Manager:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->projectManager->user->name ?? 'N/A' }}</p>
                </div>

                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-calendar-alt mr-1"></i> Created At:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->created_at->format('Y-m-d H:i') }}</p>
                </div>

                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-clock mr-1"></i> Last Updated At:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->updated_at->format('Y-m-d H:i') }}</p>
                </div>

                @if($ticket->status === 'Closed')
                <div>
                    <p class="font-bold text-orange-500 flex items-center mb-1">
                        <i class="fas fa-check-circle mr-1"></i> Closed At:
                    </p>
                    <p class="text-gray-700 text-sm">{{ $ticket->updated_at->format('Y-m-d H:i') }}</p>
                </div>
                @endif
            </div>

            <div class="mt-6">
                <p class="font-bold text-orange-500 flex items-center mb-1">
                    <i class="fas fa-align-left mr-1"></i> Description:
                </p>
                <p class="text-gray-700 text-sm">{{ $ticket->description }}</p>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition flex items-center">
                    <i class="fas fa-edit mr-2 text-sm"></i> Edit Ticket
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
