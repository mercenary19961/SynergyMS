@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center items-start">
    <div class="absolute top-4 right-4">
        <a href="{{ url()->previous() }}" class="px-4 py-2 text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 rounded-lg shadow-md">Back</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-7xl w-full p-6 mt-4">
        <!-- Left Column: Technical Support -->
        <div class="bg-white p-10 rounded-lg shadow-lg">
            <h2 class="text-2xl mb-6 font-bold text-center bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">Technical Support</h2>
            <p class="text-center text-gray-500 mb-6">If you're facing technical issues, submit a support ticket below.</p>

            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('support.submit') }}">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                    <input id="name" type="text" name="name" value="{{ auth()->user()->name }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ auth()->user()->email }}" readonly class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-100 focus:outline-none">
                </div>
                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium text-gray-700">Issue Title</label>
                    <input id="title" type="text" name="title" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
                </div>
                <div class="mb-4">
                    <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                    <select id="priority" name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="description" name="description" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600"></textarea>
                </div>
                <button type="submit" class="w-full py-2 rounded-lg text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">Submit Ticket</button>
            </form>
        </div>

        <!-- Right Column: HR Contacts -->
        <div class="bg-white p-10 rounded-lg shadow-lg">
            <h2 class="text-2xl mb-6 font-bold text-center bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">Contact HR</h2>
            <p class="text-center text-gray-500 mb-6">For non-technical issues, feel free to reach out to the HR department.</p>

            @if($hrContacts->isNotEmpty())
                @foreach($hrContacts as $hrContact)
                    <div class="mb-8 p-4 border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-300">
                        <p class="text-lg font-semibold text-orange-600"><i class="fas fa-user-tie mr-2"></i>{{ $hrContact->user->name }}</p>
                        <p class="text-md text-gray-600"><strong>Position:</strong> {{ $hrContact->position->name }}</p>
                        <p class="text-md text-gray-600"><strong>Email:</strong> <a href="mailto:{{ $hrContact->company_email }}" class="text-orange-400 hover:underline">{{ $hrContact->company_email }}</a></p>
                        <p class="text-md text-gray-600"><strong>Phone:</strong> <a href="tel:{{ $hrContact->contact_number }}" class="text-orange-400 hover:underline">{{ $hrContact->contact_number }}</a></p>
                    </div>
                @endforeach
            @else
                <p class="text-center text-gray-500">HR contact details are currently unavailable.</p>
            @endif
        </div>

    </div>
</div>
@endsection
