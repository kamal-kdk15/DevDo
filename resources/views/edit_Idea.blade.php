<!-- resources/views/edit_idea.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Project Idea</h3>
        <form action="{{ route('profile.update_idea', $idea->id) }}" method="POST">

            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="project_idea">Project Idea</label>
                <textarea name="project_idea" class="form-control" required>{{ $idea->project_idea }}</textarea>
            </div>
            <div class="form-group">
                <label for="collaboration_description">Collaboration Description</label>
                <textarea name="collaboration_description" class="form-control">{{ $idea->collaboration_description }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Idea</button>
        </form>
    </div>
@endsection

