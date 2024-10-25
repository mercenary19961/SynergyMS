@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-semibold mb-6 text-orange-600">Notifications</h2>

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
