@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Portfolio Post</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('designer.portfolio.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $post->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="design_tools">Design Tools</label>
            <input type="text" name="design_tools" class="form-control" value="{{ $post->design_tools }}">
        </div>

        <div class="form-group">
            <label for="design_specialization">Design Specialization</label>
            <input type="text" name="design_specialization" class="form-control" value="{{ $post->design_specialization }}">
        </div>

        <div class="form-group">
        <label for="image">Current Image</label><br>
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $post->image))) }}" alt="{{ $post->title }}" style="height:200px">

        <input type="file" name="image" class="form-control mt-2">
    </div>

        <div class="form-group">
            <label for="link">Project Link</label>
            <input type="url" name="link" class="form-control" value="{{ $post->link }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Portfolio Item</button>
    </form>
</div>
@endsection
