<div class="flex flex-col min-h-screen container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-3xl font-semibold text-gray-600 flex items-center">
            <i class="fas fa-bell mr-2 text-orange-500"></i> Notifications
        </h2>

        <a href="{{ route('dashboard.redirect') }}" class="bg-gray-500 text-sm sm:text-md text-white px-4 py-2 rounded hover:bg-gray-600 transition">
            <i class="fas fa-arrow-left mr-0 sm:mr-2"></i> Back
        </a>
    </div>

    @if($notifications->isEmpty())
        <p class="text-gray-600 text-lg">No notifications found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-lg shadow-md p-6 hover:bg-gray-50 transition duration-200 ease-in-out">
                    <div class="text-gray-800 font-bold mb-2">
                        @if(isset($notification->type) && $notification->type === 'App\Notifications\EventNotification')
                            <p>Event: <span class="text-sm text-orange-500">{{ $notification->data['name'] ?? 'N/A' }}</span></p>
                            <p>Description: <span class="text-sm text-gray-500">{{ $notification->data['description'] ?? 'No description' }}</span></p>
                            <p class="text-sm text-gray-500">
                                <span class="text-green-500">Start:</span> 
                                {{ \Carbon\Carbon::parse($notification->data['start_date'])->format('M d, H:i') ?? 'N/A' }}
                                - 
                                <span class="text-red-500">End:</span> 
                                {{ $notification->data['end_date'] ? \Carbon\Carbon::parse($notification->data['end_date'])->format('M d, H:i') : 'N/A' }}
                            </p>
                            <span class="block text-xs font-normal {{ isset($notification->data['message']) && str_contains($notification->data['message'], 'canceled') ? 'text-red-500' : 'text-green-500' }}">
                                * {{ $notification->data['message'] ?? 'No additional message' }}
                            </span>
                        @elseif(isset($notification->type) && $notification->type === 'App\Notifications\InvoicePaid')
                            <p>Invoice <span class="text-sm text-gray-500"> #{{ $notification->data['invoice_id'] ?? 'N/A' }}</span></p>
                            <p>Amount:<span class="text-sm text-gray-500"> ${{ $notification->data['amount'] ?? 'N/A' }}</span></p>
                            <p>Status:<span class="text-sm text-gray-500"> {{ $notification->data['status'] ?? 'Unknown' }}</span></p>
                        @elseif(isset($notification->type) && $notification->type === 'App\Notifications\ProjectRequestNotification')
                            <p>Project: <span class="text-sm text-gray-500">{{ $notification->data['name'] ?? 'N/A' }}</span></p>
                            <p>Department: <span class="text-sm text-gray-500">{{ $notification->data['department'] ?? 'N/A' }}</span></p>
                            <p>Message: <span class="text-sm text-gray-500">{{ $notification->data['message'] ?? 'No details provided' }}</span></p>
                        @elseif(isset($notification->type) && $notification->type === 'App\Notifications\TicketReviewRequested')
                            <!-- Ticket Review Request Notification -->
                            <p>Ticket Review Request: Ticket #{{ $notification->data['ticket_id'] ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $notification->data['message'] ?? 'A review has been requested for this ticket.' }}</p>
                            <a href="{{ route('admin.tickets.show', $notification->data['ticket_id']) }}" class="text-blue-500 hover:underline text-xs">
                                View Ticket
                            </a>
                        @elseif(isset($notification->type) && $notification->type === 'App\Notifications\TicketReviewConfirmed')
                            <!-- Ticket Confirmation Notification -->
                            <p>Ticket #{{ $notification->data['ticket_id'] ?? 'N/A' }} has been successfully completed by {{ $notification->data['confirmed_by'] ?? 'the project manager' }}.</p>
                            <p class="text-sm text-gray-500">{{ $notification->data['message'] ?? 'The ticket has been marked as done. Thank you for your patience.' }}</p>
                            <a href="{{ route('admin.tickets.show', $notification->data['ticket_id']) }}" class="text-blue-500 hover:underline text-xs">
                                View Ticket
                            </a>
                        @else
                            <p>Notification</p>
                        @endif
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <span class="text-sm text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>

                        <!-- Conditional View Project Button for specific notification types -->
                        @if($notification->read_at !== null && isset($notification->type) && $notification->type === 'App\Notifications\ProjectRequestNotification')
                            <a href="{{ route('admin.projects.show', $notification->data['project_id']) }}" 
                               class="flex items-center bg-orange-500 text-white px-3 py-1 rounded-md hover:bg-orange-600 transition">
                                <i class="fas fa-eye mr-2"></i> View Project
                            </a>
                        @endif

                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        @if($notification->read_at === null)
                            <button wire:click="markAsRead('{{ $notification->id }}')" 
                                    class="flex items-center bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition">
                                <i class="fas fa-check-circle mr-2"></i> Mark as read
                            </button>
                        @else
                            <span class="flex items-center bg-gray-200 text-gray-500 px-3 py-1 rounded-md">
                                <i class="fas fa-check-circle mr-2 text-green-500"></i> Read
                            </span>
                        @endif
                    
                        <!-- Delete Button -->
                        <button wire:click="deleteNotification('{{ $notification->id }}')" 
                                class="flex items-center bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition ml-2">
                            <i class="fas fa-trash mr-2"></i> Delete
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination Links -->
        <div class="mt-auto mb-10 ">
            {{ $notifications->links() }}
        </div>
    @endif
</div>
