@extends('layouts.app')

@section('no-header') @endsection

@section('content')
    <!-- Registration Form Column -->
    @if (session()->has('status'))
        <div class="mb-4 text-sm font-medium text-green-600">
            {{ session('status') }}
        </div>
    @endif
    @livewire('registration-form')
@endsection
