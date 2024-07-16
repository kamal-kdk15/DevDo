@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Team Member</h1>
    <form action="{{ route('profile.updateTeamMember', $teamMember->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <!-- Include form fields for name, role, bio, and photo -->
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ $teamMember->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="role">Role</label>
            <input type="text" name="role" value="{{ $teamMember->role }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" class="form-control" required>{{ $teamMember->bio }}</textarea>
        </div>
        <div class="form-group">
            <label for="photo">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>
        <!-- Button to update team member -->
        <button type="submit" class="btn btn-primary">Update Team Member</button>
    </form>

 
</div>
@endsection
