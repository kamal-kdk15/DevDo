@extends('adminlte::page')

@section('title', 'Vacancy Application Details')

@section('content_header')
    <h1>Vacancy Application Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <h2>User: {{ $application->user->name }}</h2>
            <p>Vacancy: {{ $application->vacancy->title }}</p>
            <p>Status: {{ $application->status }}</p>
            <!-- Add more details or actions as needed -->
        </div>
    </div>
@stop
