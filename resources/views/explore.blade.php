@extends('layouts.app')

@section('content')

<style>
    .post-card {
        background-color: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        margin-bottom: 20px;
        height: 100%;
    }

    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.3);
    }

    .card-body {
        color: white;
    }

    .card-title {
        color: #ff69b4;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .card-subtitle {
        color: #00ff99;
        margin-bottom: 10px;
    }

    .post-image {
        height: 230px;
        border-radius: 10px;
        object-fit: cover;
    }

    .btn-primary,
    .btn-secondary,
    .btn-info {
        background-color: rgba(255, 255, 255, 0.8);
        color: black;
        border: none;
        transition: background-color 0.3s ease;
        margin-right: 10px;
        border-radius: 5px;
    }

    .btn-primary:hover,
    .btn-secondary:hover,
    .btn-info:hover {
        background-color: rgba(255, 255, 255, 0.9);
        color: black;
    }

    .btn-primary.active {
        background-color: #ff4d4d;
        color: white;
    }

    .btn-secondary {
        background-color: #ff69b4;
        color: white;
    }

    .btn-info {
        background-color: #00ff99;
        color: white;
    }

    .comment {
        background-color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.125);
        border-radius: 5px;
        padding: 10px;
        margin-top: 10px;
    }

    .like-comment-btn {
        color: black;
    }

    .like-comment-btn:hover {
        color: #007bff;
    }

    .like-comment-btn.active {
        color: #ff4d4d;
    }

    .modal-content {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background-color: #00c6ff;
        color: white;
        border-bottom: none;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .modal-title {
        font-weight: bold;
    }

    .modal-body {
        color: black;
    }

    .modal-footer {
        background-color: rgba(255, 255, 255, 0.9);
        border-top: none;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .modal-footer button {
        color: #00c6ff;
        border: none;
    }

    .modal-footer button:hover {
        text-decoration: underline;
    }

    .modal-backdrop {
        backdrop-filter: blur(5px);
    }

    .btn-pink {
        background-color: #ff69b4;
        color: white;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-pink:hover {
        background-color: #ff1493;
        color: white;
    }

    .glass-effect {
        background-color: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(5px);
    }
</style>
<div class="container">
<h3 style="  color: #AA336A">Explore</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="row">
                @foreach($devPosts as $post)
                <div class="col-md-3 mb-3">
                    <div class="card post-card">
                        <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                @foreach($post->postImages as $imageIndex => $image)
                                <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                    <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 150px; object-fit: cover;">
                                </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExample{{ $post->id }}" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExample{{ $post->id }}" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                        <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                                @if($post->user->profile_image)
                                <img src="{{ asset('portfolio_images/' . $recommendation->portfolioPosts->first()->image) }}" class="img-fluid rounded-circle" alt="{{ $recommendation->name }}'s Portfolio" style="width: 100%; height: 100%; object-fit: cover;">
                                @endif
                                <a href="{{ route('profile.show', $post->user->id) }}" style="color: #00ff99;">{{ $post->user->name }}</a>
                            </div>
                            <h5 class="card-title">{{ $post->subtitle }}</h5>
                            <p style="color:white" class="card-text post-description">{{ Str::limit($post->description, 45) }}</p>
                            @if($post->project_link)
                            <p><a href="{{ $post->project_link }}" target="_blank" class="project-link">Project Link</a></p>
                            @endif
                            <div class="post-actions d-flex justify-content-between">
                                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="like-post-form mr-2">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" style="width: 100%;">
                                        <i class="fas fa-thumbs-up"></i>
                                        {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'Unlike' : 'Like' }}
                                        ({{ $post->likes()->count() }})
                                    </button>
                                </form>
                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#commentModal{{ $post->id }}">
                                    Comment ({{ $post->comments()->count() }})
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Comment Modal -->
                <div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel{{ $post->id }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="commentModalLabel{{ $post->id }}">Comments on "{{ $post->title }}"</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                        <p class="text-muted">{{ $post->description }}</p>
                        <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="comment">Comment</label>
                                <textarea name="comment" class="form-control" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Comment</button>
                        </form>
                        <h6 class="mt-4">Comments</h6>
                        @foreach($post->comments as $comment)
                            <div class="comment mt-2 p-2 border rounded">
                                <strong>{{ $comment->user->name }}:</strong> {{ $comment->comment }}
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    <button class="btn btn-sm btn-outline-primary like-comment-btn" data-comment-id="{{ $comment->id }}">
                                        {{ auth()->user()->likedComments->contains($comment->id) ? 'Unlike' : 'Like' }}
                                        (<span class="like-count">{{ $comment->likes->count() }}</span>)
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

@endsection
