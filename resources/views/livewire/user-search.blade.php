<div class="relative">
    <!-- Input field for typing and displaying the selected user's name -->
    <input 
        type="text" 
        class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:border-orange-500 focus:outline-none" 
        placeholder="Search for user..." 
        wire:input="searchUsers($event.target.value)" 
        wire:model.defer="query"
        autocomplete="off">
    
    <!-- Hidden field to store the selected user_id -->
    <input type="hidden" name="user_id" value="{{ $userId }}">

    <!-- User search results dropdown -->
    @if(!empty($users))
        <ul class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto">
            @foreach($users as $user)
                <li 
                    wire:click="selectUser({{ $user->id }})" 
                    class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-orange-500 hover:text-white flex items-center group">
                    <i class="fas fa-user mr-2 text-orange-500 group-hover:text-white"></i> 
                    {{ $user->name }} ({{ $user->email }})
                </li>
            @endforeach
        </ul>
    @endif
</div>
