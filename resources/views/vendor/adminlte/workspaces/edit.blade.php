@extends('adminlte::page')

@section('title', 'Admin - Edit Workspace')

@section('content_header')
    <h1>Edit Workspace</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.workspaces.update', $workspace) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="idea_title">Idea Title:</label>
                    <input type="text" id="idea_title" class="form-control" value="{{ $workspace->idea->project_idea }}" disabled>
                </div>

                <div class="form-group">
                    <label for="collaboration_description">Collaboration Description:</label>
                    <textarea name="collaboration_description" id="collaboration_description" class="form-control" rows="5">{{ $workspace->idea->collaboration_description }}</textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status:</label>
                    <select name="status" id="status" class="form-control">
                        <option value="pending" {{ $workspace->idea->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $workspace->idea->status === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $workspace->idea->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Workspace</button>
            </form>
        </div>
    </div>
@stop
