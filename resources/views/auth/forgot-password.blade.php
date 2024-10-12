@extends('layouts.app')

@section('content')
<div class="flex justify-center items-center min-h-screen bg-gray-100">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold text-center mb-2">Forgot Password</h2>
        <p class="text-center text-gray-500 mb-6">Enter your email to reset your password</p>

        @if (session('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('email')
                    <span class="text-red-500 text-xs mt-2">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full py-2 rounded-lg text-white bg-gradient-to-r from-orange-500 to-pink-500 hover:from-orange-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-orange-400 focus:ring-offset-2">Send Password Reset Link</button>
        </form>
    </div>
</div>
@endsection