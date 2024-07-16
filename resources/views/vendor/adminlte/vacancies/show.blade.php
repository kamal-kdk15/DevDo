@extends('adminlte::page')

@section('title', 'Admin - Vacancy Details')

@section('content_header')
    <h1>Vacancy Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>Title: {{ $vacancy->title }}</h2>
            <p>Description: {{ $vacancy->description }}</p>
            <p>Location: {{ $vacancy->location }}</p>
            <p>Type: {{ $vacancy->type }}</p>
            <p>Experience: {{ $vacancy->experience }}</p>
            <p>Minimum Qualification: {{ $vacancy->minimum_qualification }}</p>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h3>Applicants for {{ $vacancy->title }}</h3>
            @if ($vacancy->applications->isEmpty())
                <p>No applicants found for this vacancy.</p>
            @else
                <ul>
                    @foreach ($vacancy->applications as $application)
                        <li>{{ $application->user->name }} - Status: {{ $application->status }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@stop
