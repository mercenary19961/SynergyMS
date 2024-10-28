<div>
    <h2 class="text-lg mb-2 text-gray-700 flex items-center border-b-2 pb-4">
        <i class="fas fa-bell mr-2 text-gray-700"></i> Notifications
    </h2>
    @if($notifications->isEmpty())
        <p class="text-gray-600 text-sm">No new notifications</p>
    @else
        <ul class="divide-y divide-gray-200">
            @foreach($notifications as $notification)
                <li id="notification-{{ $notification->id }}" class="py-2 hover:bg-gray-50 rounded-md">
                    <div class="block text-gray-700 text-sm font-semibold">
                        @if(isset($notification->type) && $notification->type === 'App\Notifications\InvoicePaid')
                            Invoice #{{ $notification->data['invoice_id'] ?? 'N/A' }}
                            <span class="block text-xs font-normal text-gray-500">
                                Amount: ${{ $notification->data['amount'] ?? 'N/A' }} - 
                                Status: {{ $notification->data['status'] ?? 'Unknown' }}
                            </span>
                            @elseif(isset($notification->type) && $notification->type === 'App\Notifications\ProjectRequestNotification')
                            Project Request: {{ $notification->data['name'] ?? 'N/A' }}
                            <span class="block text-xs font-normal text-gray-500">
                                Department: {{ $notification->data['department'] ?? 'N/A' }}
                            </span>
                            <span class="block text-xs text-gray-500">
                                {{ $notification->data['message'] ?? 'No details provided' }}
                            </span>
                        @else
                            Notification
                        @endif
                    </div>
                    <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>

                    <button wire:click="markAsRead('{{ $notification->id }}')"
                            class="flex items-center bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition mt-2">
                        <i class="fas fa-check-circle mr-2"></i> Mark as read
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>
