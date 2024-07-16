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
            <!-- Add more details or actions as needed -->
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header">
            <h3>Applications for this Vacancy</h3>
        </div>
        <div class="card-body">
            @if ($vacancy->applications->isEmpty())
                <p>No applications found for this vacancy.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Applicant Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($vacancy->applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td>{{ $application->user->name }}</td>
                                <td>{{ $application->status }}</td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $application) }}" class="btn btn-info">View Application</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop
