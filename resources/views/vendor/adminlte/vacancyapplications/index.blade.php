@extends('adminlte::page')

@section('title', 'Admin - Vacancy Applications')

@section('content_header')
    <h1>Vacancy Applications</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($applications->isEmpty())
                <p>No vacancy applications found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Vacancy Title</th>
                            <th>Applicant Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                            <tr>
                                <td>{{ $application->id }}</td>
                                <td>{{ $application->vacancy->title }}</td>
                                <td>{{ $application->user->name }}</td>
                                <td>
                                    <a href="{{ route('admin.applications.show', $application) }}" class="btn btn-info">View</a>
                                    <form action="{{ route('admin.applications.destroy', $application) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@stop
