@extends('layouts.app')

@section('content')
<div class="container">
    <h1 style="  color: #AA336A">Search Results</h1>

    @if ($users->isEmpty() && $designerPortfolioPosts->isEmpty())
        <p>No results found.</p>
    @else
        <div class="row">
            {{-- Display Users --}}
            @foreach ($users as $user)
            <div class="col-md-3 mb-4">
                <div class="card h-100 border-0 rounded-3 shadow" style="background-color: rgba(255, 255, 255, 0.20); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
                    <div class="card-body text-center" style="color: white;">
                        <!-- Profile Image -->
                        <div class="rounded-circle overflow-hidden mx-auto glass-effect" style="width: 80px; height: 80px;">
                            @if ($user->portfolioPosts->isNotEmpty())
                                <img src="{{ asset('portfolio_images/' . $user->portfolioPosts->first()->image) }}" class="img-fluid rounded-circle" alt="{{ $user->name }}'s Portfolio" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div class="no-portfolio-image d-flex justify-content-center align-items-center" style="width: 100%; height: 100%; background-color: #f0f0f0;">
                                    <p class="text-muted m-0">No image available</p>
                                </div>
                            @endif
                        </div>
                        <!-- User Name -->
                        <h5 class="card-title mt-3 mb-0 text-black">{{ $user->name }}</h5>
                        <!-- Follow and View Profile Buttons -->
                        <div class="d-flex justify-content-center mt-3">
                            @auth
                                @if(auth()->user()->id !== $user->id)
                                    @if(auth()->user()->isFollowing($user))
                                        <form action="{{ route('profile.unfollow', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                                        </form>
                                    @else
                                        <form action="{{ route('profile.follow', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Follow</button>
                                        </form>
                                    @endif
                                @endif
                            @endauth
                            <a href="{{ route('profile.show', $user->id) }}" class="btn btn-secondary btn-sm ml-2">View</a>
                        </div>
                        <!-- Display all portfolio posts -->
                        @foreach ($user->portfolioPosts as $portfolioPost)
                            <div class="mt-3">
                                <h6 class="card-subtitle mt-2 mb-2 text-muted">{{ $portfolioPost->title }}</h6>
                                <p class="card-text">{{ $portfolioPost->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach

           
        </div>
    @endif
</div>
@endsection
