@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Workspace</h1>

        <form action="{{ route('workspaces.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Workspace Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="idea_id">Related Idea ID</label>
                <input type="text" class="form-control" id="idea_id" name="idea_id" required>
            </div>
            <div class="form-group">
                <label for="user_id">User ID</label>
                <input type="text" class="form-control" id="user_id" name="user_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Workspace</button>
        </form>
    </div>
@endsection
