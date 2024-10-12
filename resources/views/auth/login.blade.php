@extends('layouts.app')


@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full">
        <div class="absolute top-4 right-4">
            <a href="{{ route('contact.submit') }}" class="px-4 py-2 text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 rounded-lg shadow-md">Contact Us</a>
        </div>
        <div class="flex justify-center">
            <iframe src="https://lottie.host/embed/3afd22fc-9347-415a-9de2-d41124ef773c/wM2MpWyZL4.json"></iframe>
        </div>
        <h1 class="text-2xl font-bold text-center bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">SynergyMS</h1>
        <h2 class="text-2xl font-bold text-center bg-gradient-to-r from-orange-500 to-pink-500 bg-clip-text text-transparent">Login</h2>
        <p class="text-center text-gray-500 mt-6 mb-2">Access to our dashboard</p>

        @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
        
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600 bg-gray-100 text-gray-800">
                @error('email')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>
        
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <!-- Adjusted background color to a dark gray and text to light gray -->
                <input id="password" type="password" name="password" placeholder="Password" required class="w-full px-4 py-2 border border-red-500 rounded-lg focus:outline-none focus:ring-1 focus:ring-pink-600 bg-gray-100 text-gray-800">
                @error('password')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>
        
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('password.request') }}" class="text-sm text-gray-500 hover:text-gray-800">Forgot password?</a>
            </div>
        
            <button type="submit" class="w-full py-2 rounded-lg text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">Login</button>
        </form>
        
    </div>
</div>
@endsection
