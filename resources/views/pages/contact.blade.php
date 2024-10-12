@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex justify-center items-center">
    <div class="absolute top-4 right-4">
        <a href="{{ route('login') }}" class="px-4 py-2 text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 rounded-lg shadow-md">Go To Login</a>
    </div>
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl mb-6 font-bold text-center bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">Contact Us</h2>
        <p class="text-center text-gray-500 mb-6">If you want to make a project or if you have questions, feel free to reach out to us using the form below.</p>
        
        <form method="POST" action="{{ route('contact.submit') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                <input id="name" type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600">
            </div>
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                <textarea id="message" name="message" rows="4" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600"></textarea>
            </div>
            <button type="submit" class="w-full py-2 rounded-lg text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">Send Message</button>
        </form>
    </div>
</div>
@endsection
