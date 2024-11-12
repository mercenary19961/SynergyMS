<div class="bg-white p-3 rounded shadow-lg h-[32rem]">
    <div class="flex justify-center items-center mb-6">
        <i class="fas fa-ticket-alt text-orange-500 mr-2"></i>
        <h2 class="font-semibold text-lg">Assigned Tickets</h2>
    </div>
    
    <div class="overflow-x-auto">
        <ul class="flex space-x-4">
            @php
                $inProgressTickets = $tickets->filter(fn($ticket) => $ticket->status === 'In Progress');
            @endphp

            @forelse($inProgressTickets as $ticket)
                <li class="bg-gray-50 p-4 rounded shadow flex flex-col min-w-[200px] max-w-[300px] h-[24rem]">
                    <div class="flex flex-col flex-1">
                        <p class="font-semibold text-lg text-orange-600">{{ $ticket->title }}</p>
                        <p class="text-sm text-gray-500 mb-4">{{ $ticket->description }}</p>
                        
                        <!-- Ticket Information: Project, Priority, Status, Issuer, and Assigned To -->
                        <div class="mt-auto">
                            <!-- Ticket Issuer -->
                            <p class="text-gray-700"><strong>Issued By:</strong> 
                                <span class="text-gray-500 text-sm">{{ $ticket->user->name ?? 'N/A' }}</span>
                            </p>

                            @if($ticket->project)
                                <p class="text-gray-700"><strong>Project:</strong> <span class="text-gray-500 text-sm">{{ $ticket->project->name }}</span></p>
                            @endif

                            <p class="text-gray-700">
                                <strong>Priority:</strong> 
                                <span class="text-sm 
                                    {{ $ticket->priority === 'High' ? 'text-red-500' : '' }}
                                    {{ $ticket->priority === 'Medium' ? 'text-orange-500' : '' }}
                                    {{ $ticket->priority === 'Low' ? 'text-green-500' : '' }}">
                                    {{ ucfirst($ticket->priority) }}
                                </span>
                            </p>
                            
                            <p class="text-gray-700"><strong>Status:</strong> <span class="text-gray-500 text-sm">{{ ucfirst($ticket->status) }}</span></p>

                            <p class="text-gray-700"><strong>Assigned To:</strong></p>
                            <div class="flex items-center mt-1">
                                <img src="{{ asset('storage/' . $ticket->employee->user->image) }}" alt="Assignee Image" class="w-8 h-8 rounded-full border-2 border-gray-300">
                                <span class="ml-2 text-gray-500 text-sm">{{ $ticket->employee->user->name }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Collaborators (if any) -->
                    @if($ticket->collaborators && $ticket->collaborators->count() > 0)
                        <div class="mt-4">
                            <p class="text-gray-700"><strong>Collaborators:</strong></p>
                            <div class="flex -space-x-2 mt-1">
                                @foreach($ticket->collaborators->unique('employee.id') as $collaborator)
                                    <img src="{{ asset('storage/' . $collaborator->user->image) }}" alt="{{ $collaborator->name }}" title="{{ $collaborator->name }}" class="w-8 h-8 rounded-full border-2 border-gray-300">
                                @endforeach
                                @if($ticket->collaborators->unique('employee.id')->count() > 5)
                                    <span class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center text-xs">+{{ $ticket->collaborators->unique('employee.id')->count() - 5 }}</span>
                                @endif
                            </div>
                        </div>
                    @endif
                    
                    <!-- View Ticket Button at the bottom -->
                    <div class="flex justify-center mt-4">
                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-full text-center">View Ticket</a>
                    </div>
                </li>
            @empty
                <div class="flex flex-col items-center justify-center w-full h-[24rem] text-center bg-gray-50 rounded p-6">
                    <p class="text-gray-500 mb-4">You currently have no tickets assigned that are in progress.</p>
                    <a href="{{ route('admin.tickets.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-full">
                        Take a Ticket
                    </a>
                </div>
            @endforelse
        </ul>
    </div>
</div>
