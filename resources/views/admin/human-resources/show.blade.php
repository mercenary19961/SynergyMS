@extends('layouts.app')

@section('content')
    <h1>{{ $humanResource->user->name }}'s Details</h1>

    <p><strong>Department:</strong> {{ $humanResource->department }}</p>
    <p><strong>Position:</strong> {{ $humanResource->position }}</p>
    <p><strong>Contact Number:</strong> {{ $humanResource->contact_number }}</p>
    <p><strong>Company Email:</strong> {{ $humanResource->company_email }}</p>

    <a href="{{ route('hr.index') }}" class="btn btn-secondary">Back to List</a>
@endsection
