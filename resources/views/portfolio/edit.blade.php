@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Portfolio</h1>
<form action="{{ route('portfolio.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Include form fields for title, description, image, link, etc. -->
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" value="{{ $post->title }}" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea name="description" class="form-control" required>{{ $post->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="work_experience">Work Experience</label>
        <input type="text" name="work_experience" value="{{ $post->work_experience }}" class="form-control">
    </div>
    <div class="form-group">
    <label for="image">Current Image</label><br>
    <img src="{{ asset('portfolio_images/' . $post->image) }}" alt="{{ $post->title }}" height="200px">

    <input type="file" name="image" class="form-control mt-2">
</div>

    <div class="form-group">
        <label for="link">Project Link</label>
        <input type="url" name="link" value="{{ $post->link }}" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update Portfolio Post</button>
</form>
</div>
@endsection
