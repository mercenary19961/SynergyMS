@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <!-- Title with Icon -->
        <h2 class="text-3xl font-semibold text-gray-600 flex items-center">
            <i class="fas fa-bell mr-2 text-orange-500"></i> <!-- Icon -->
            Notifications
        </h2>
    
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-2"></i> <!-- Icon -->
            Back
        </a>
    </div>

    @if($notifications->isEmpty())
        <p class="text-gray-600 text-lg">No notifications found.</p>
    @else
        <div class="bg-white rounded-lg shadow-lg">
            <ul class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <li class="py-4 px-6 hover:bg-orange-50 transition duration-200 ease-in-out">
                        <div class="flex justify-between items-center">
                            <div class="text-gray-800 font-medium">
                                <span>Invoice #{{ $notification->data['invoice_id'] }}</span>
                                <span>- Amount: ${{ $notification->data['amount'] }}</span>
                                <span>- Status: {{ $notification->data['status'] }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center mt-2">
                            @if($notification->read_at === null)
                                <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-sm text-blue-500 hover:text-blue-700">Mark as read</button>
                                </form>
                            @else
                                <span class="text-sm text-green-500">Read</span>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
@endsection
