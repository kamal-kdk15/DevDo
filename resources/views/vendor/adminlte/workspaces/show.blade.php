@extends('adminlte::page')

@section('title', 'Admin - Workspace Details')

@section('content_header')
    <h1>Workspace Details</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $workspace->id }}</p>
            <p><strong>Idea Title:</strong> {{ $workspace->idea->title }}</p>
            <p><strong>User:</strong> {{ $workspace->user->name }}</p>
            <p><strong>Created At:</strong> {{ $workspace->created_at }}</p>

            <p><strong>Project Idea:</strong> {{ $workspace->idea->project_idea }}</p>
            <p><strong>Collaboration Description:</strong> {{ $workspace->idea->collaboration_description }}</p>

            <h3>Applicants</h3>
            @if ($workspace->idea->collaborationRequests->isEmpty())
                <p>No applicants found.</p>
            @else
                <ul>
                    @foreach ($workspace->idea->collaborationRequests as $request)
                        <li>
                            <strong>User:</strong> {{ $request->user->name }} |
                            <strong>Status:</strong> {{ $request->status }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@stop
