@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"  style="color:black">Edit Dev Post</div>

                    <div class="card-body" style="color:black">
                        <form action="{{ route('dev_posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
                            </div>
                            <div class="form-group">
                                <label for="subtitle">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control" value="{{ $post->subtitle }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" required>{{ $post->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="images">Images</label>
                                <input type="file" name="images[]" class="form-control-file" multiple>
                                @foreach($post->postImages as $image)
                                    <div class="mt-2">
                                        <img src="{{ asset($image->image_path) }}" alt="Post Image" style="width: 100px; height: auto;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remove_images[]" value="{{ $image->id }}" id="remove_image_{{ $image->id }}">
                                            <label class="form-check-label" for="remove_image_{{ $image->id }}">Remove</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="project_link">Project Link</label>
                                <input type="url" name="project_link" class="form-control" value="{{ $post->project_link }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
