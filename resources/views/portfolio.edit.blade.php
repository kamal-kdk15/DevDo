@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Portfolio Post</h2>
    <form action="{{ route('portfolio.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $post->title }}">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control">{{ $post->description }}</textarea>
        </div>
        <!-- Other input fields for editing portfolio post attributes -->
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
