@extends('adminlte::page')

@section('title', 'Vacancy Applications')

@section('content_header')
    <h1>Vacancy Applications</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($applications->isEmpty())
                <p>No applications found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Vacancy</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($applications as $application)
                            <tr>
                                <td>{{ $application->user->name }}</td>
                                <td>{{ $application->vacancy->title }}</td>
                                <td>{{ $application->status }}</td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $application->id) }}" class="btn btn-primary">View</a>
                                    <!-- Add edit and delete buttons as needed -->
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop
