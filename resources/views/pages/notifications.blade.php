@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-semibold text-gray-600 flex items-center">
            <i class="fas fa-bell mr-2 text-orange-500"></i> Notifications
        </h2>

        <a href="{{ url()->previous() }}" class="bg-gray-500 text-sm sm:text-md text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-0 sm:mr-2 "></i> Back
        </a>
    </div>

    @if($notifications->isEmpty())
        <p class="text-gray-600 text-lg">No notifications found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($notifications as $notification)
            <div class="bg-white rounded-lg shadow-md p-6 hover:bg-gray-50 transition duration-200 ease-in-out">
                <div class="text-gray-800 font-bold mb-2">
                    @if(isset($notification->type) && $notification->type === 'App\Notifications\InvoicePaid')
                        <p>Invoice <span class="text-sm text-gray-500"> #{{ $notification->data['invoice_id'] ?? 'N/A' }}</span></p>
                        <p>Amount:<span class="text-sm text-gray-500 "> ${{ $notification->data['amount'] ?? 'N/A' }}</span></p>
                        <p>Status:<span class="text-sm text-gray-500 "> {{ $notification->data['status'] ?? 'Unknown' }}</span></p>
                    @elseif(isset($notification->type) && $notification->type === 'App\Notifications\ProjectRequestNotification')
                        <p>Project: <span class="text-sm text-gray-500">{{ $notification->data['name'] ?? 'N/A' }}</span></p>
                        <p>Department: <span class="text-sm text-gray-500 ">{{ $notification->data['department'] ?? 'N/A' }}</span></p>
                        <p>Message: <span class="text-sm text-gray-500">{{ $notification->data['message'] ?? 'No details provided' }}</span></p>
                    @else
                        <p>Notification</p>
                    @endif
                </div>

                <div class="flex justify-between items-center mt-4">
                    <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>

                    <!-- Conditional View Project Button -->
                    @if($notification->read_at !== null && isset($notification->type) && $notification->type === 'App\Notifications\ProjectRequestNotification')
                        <a href="{{ route('admin.projects.show', $notification->data['project_id']) }}" 
                           class="flex items-center bg-orange-500 text-white px-3 py-1 rounded-md hover:bg-orange-600 transition">
                            <i class="fas fa-eye mr-2"></i> View Project
                        </a>
                    @endif
                </div>

                <div class="mt-4 flex justify-between items-center">
                    @if($notification->read_at === null)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="flex items-center bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                <i class="fas fa-check-circle mr-2"></i> Mark as read
                            </button>
                        </form>
                    @else
                        <span class="text-sm text-green-500">Read</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
