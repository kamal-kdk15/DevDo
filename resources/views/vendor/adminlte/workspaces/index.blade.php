@extends('adminlte::page')

@section('title', 'Admin - Workspaces')

@section('content_header')
    <h1>Workspaces</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($workspaces->isEmpty())
                <p>No workspaces found.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Idea</th>
                            <th>User</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workspaces as $workspace)
                            <tr>
                                <td>{{ $workspace->id }}</td>
                                <td>{{ $workspace->idea->title ?? $workspace->idea->id }}</td>
                                <td>{{ $workspace->user->name }}</td>
                                <td>{{ $workspace->created_at }}</td>
                                <td>
                                    <a href="{{ route('admin.workspaces.show', $workspace) }}" class="btn btn-info">View</a>
                                    <a href="{{ route('admin.workspaces.edit', $workspace) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('admin.workspaces.destroy', $workspace) }}" method="POST" style="display:inline-block;">
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
