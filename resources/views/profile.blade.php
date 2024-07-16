@extends('layouts.app')

@section('content')
<section class="container" style="background-image: url('https://i.pinimg.com/564x/59/cd/e9/59cde9bd4ec4da9380702758bd39d044.jpg'); background-size: cover; background-position: center; margin-top: -3%;">

    @if($userDetails)
    <div class="bg-icons {{ $userDetails->account_type }}"></div>
    <div class="profile-header" style="background-color: #0d0d27; margin-left:-13px; margin-right:-13px; border-radius:0; padding: 20px;">
        @if(Auth::id() === $userDetails->user_id)
        <h1>Welcome to Your Profile, {{ Auth::user()->name }}!</h1>
        <p>Your email is {{ Auth::user()->email }}</p>
        @endif
    </div>

    <!-- Modals for Followers and Following Lists -->
    <div>
        <!-- Followers Modal -->
        <div class="modal fade" id="followersModal" tabindex="-1" role="dialog" aria-labelledby="followersModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="followersModalLabel" style="color: #0d0d27;">Followers</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if($followers->isEmpty())
                        <p style="color: #0d0d27;">No followers yet.</p>
                        @else
                        <ul>
                            @foreach($followers as $follower)
                            <li><a href="{{ route('user.profile', ['id' => $follower->id]) }}">{{ $follower->name }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Following Modal -->
        <div class="modal fade" id="followingModal" tabindex="-1" role="dialog" aria-labelledby="followingModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="followingModalLabel" style="color: #0d0d27;">Following</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if($following->isEmpty())
                        <p style="color: #0d0d27;">Not following anyone yet.</p>
                        @else
                        <ul>
                            @foreach($following as $follow)
                            <li><a href="{{ route('user.profile', ['id' => $follow->id]) }}">{{ $follow->name }}</a></li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $article = \App\Models\Article::find($userDetails->user_id);
    @endphp
<!-- 
@if(auth()->user()->id !== $user->id)
                                    @if(auth()->user()->isFollowing($user))
                                        <form action="{{ route('profile.unfollow', $user->id) }}" method="POST" style="background: transparent;">
                                            @csrf
                                            <button type="submit" style="background-color:red; padding:10px;" class="btn btn-danger btn-sm">Unfollow</button>
                                        </form>
                                    @else
                                        <form action="{{ route('profile.follow', $user->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Follow</button>
                                        </form>
                                    @endif
                                @endif -->
    <div class="profile-content glass" style="margin:50px;">
        @if($userDetails->account_type === 'Developer')
        <h2>Developer Profile</h2>
        <section>
            <!-- <h3>Portfolio</h3> -->
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if ($portfolioPosts->isEmpty())
            <form id="portfolioPostForm" action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <div class="form-group">
                    <label for="link">Project Link</label>
                    <input type="url" name="link" class="form-control">
                </div>
                <div class="form-group">
                    <label for="work_experience">Work Experience</label>
                    <input type="text" name="work_experience" class="form-control" placeholder="Fresher, Experienced, Learner, Freelancer">
                </div>
                <button type="submit" class="btn btn-primary">Post</button>
            </form>
            @endif

            @foreach($portfolioPosts as $post)
<div class="portfolio-post" style="display: flex; flex-wrap: wrap; margin-bottom: 30px; text-align: center;">

    <!-- Followers, Following, Posts Section -->
    <div style="flex: 100%; display: flex; justify-content: center; align-items: center; margin-top: 20px; margin-bottom: 30px;">
        <div style="flex: 1;">
            <h4>Followers</h4>
            <h5><a style="text-decoration: none; color:#00FF99" href="#" id="showFollowers" data-toggle="modal" data-target="#followersModal">{{ $followerCount }}</a></h5>
        </div>
        <div style="flex: 1;">
            <h4 style="color: white;">Following</h4>
            <h5><a style="text-decoration: none; color:#00FF99" href="#" id="showFollowing" data-toggle="modal" data-target="#followingModal">{{ $followingCount }}</a></h5>
        </div>
        <div style="flex: 1;">
            <h4 style="color: white;">Posts</h4>
            <h5>{{ $devPostCount }}</h5>
        </div>
    </div>

    <!-- Post Image -->
    @if($post->image)
    <div class="post-image" style="flex: 1 1 100%; margin-right: 20px;">
        <img src="{{ asset('portfolio_images/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100%; height: 250px;">
        <div class="bubble"></div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="post-content" style="flex: 2;">
        <h4>{{ $post->title }}</h4>
        <p>{{ $post->description }}</p>
        <p>Work Experience: {{ $post->work_experience }}</p>
        <p><a href="{{ $post->link }}" target="_blank">My Best Project</a></p>

        <!-- Follow/Unfollow Button -->
        @if(auth()->user()->id !== $user->id)
            @if(auth()->user()->isFollowing($user))
                <form action="{{ route('profile.unfollow', $user->id) }}" method="POST" style="background: transparent; margin-top: 10px; box-shadow: none">
                    @csrf
                    <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px">Unfollow</button>
                </form>
            @else
                <form action="{{ route('profile.follow', $user->id) }}" method="POST" style="margin-top: 10px; background: transparent; box-shadow: none">
                    @csrf
                    <button type="submit" style="background-color: green; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px">Follow</button>
                </form>
            @endif
        @endif

        <!-- Edit Button (only visible to owner) -->
        @if(Auth::id() === $userDetails->user_id)
            <a href="{{ route('portfolio.edit', $post->id) }}" class="btn btn-sm btn-primary" style="margin-top: 10px;">Edit</a>
        @endif
    </div>

</div>
@endforeach

<!-- resources/views/portfolio/edit.blade.php -->

@if(Auth::id() === $userDetails->user_id)
<h3>Add Language Skill</h3>
<form action="{{ route('profile.store_language_skill') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="language">Language</label>
        <input type="text" name="language" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="percentage">Percentage</label>
        <input type="number" name="percentage" class="form-control" min="0" max="100" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Skill</button>
</form>
@endif
<div id="skillsContainer">
    @foreach($languageSkills as $skill)
    <div class="skill" data-percentage="{{ $skill->percentage }}" data-language="{{ $skill->language }}">
        <div class="circle">
            <div class="bar"></div>
            <div class="box"><span>{{ $skill->percentage }}%</span></div>
        </div>
        <h4>{{ $skill->language }}</h4>
        @if(Auth::id() === $userDetails->user_id)
        <form action="{{ route('profile.delete_language_skill', $skill->id) }}" method="POST" class="delete-form"style="background-color: transparent; box-shadow: none">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger delete-skill-btn" style="height: 40px; font-size: 15px;padding: 4px 8px;">Delete</button>

        </form>
        @endif
    </div>
    @endforeach
</div>
<section>
    @if(Auth::id() === $userDetails->user_id)
        <h3>Add Categories</h3>
        <form action="{{ route('profile.add_category') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    @endif
</section>

<section>
    <ul class="nav nav-tabs" id="categoryTabs" >
        @foreach($categories as $category)
            <li class="nav-item" >
                <a style="background-color: #77C4ED;"  class="nav-link  {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#category_{{ $category->id }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</section>

@if(Auth::id() === $userDetails->user_id)
    <div style="display: flex; justify-content: space-between; align-items: center;">
        @foreach($categories as $category)
            <form action="{{ route('categories.delete', $category->id) }}" method="POST" style="display: inline;background:transparent; box-shadow: none;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="height: 30px; font-size: 15px; padding: 4px 8px;" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
            </form>
        @endforeach
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        @foreach($categories as $category)
            <a class="btn btn-sm btn-primary" href="{{ route('categories.edit', $category->id) }}" style="height: 30px; font-size: 15px; padding: 4px 8px; margin-top: -15%; width: 50px;">Edit</a>
        @endforeach
    </div>
@endif

<div class="tab-content" id="categoryTabContent">
    @foreach($categories as $category)
        <div id="category_{{ $category->id }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}">
            <div class="row">
                <div class="col-md-12">
                    @if(Auth::id() === $userDetails->user_id)
                        <div class="add-post-circle">
                            <div class="circle" id="toggleForm{{ $category->id }}">
                                <img src="https://cdn-icons-png.flaticon.com/512/117/117885.png" alt="Add Icon">
                            </div>
                        </div>
                        <div class="add-post-form" id="addPostForm{{ $category->id }}" style="display: none;">
                            <h3>Add Post</h3>
                            <form action="{{ route('profile.add_post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>
                                <div id="imageInputContainer{{ $category->id }}">
                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <input type="file" name="images[]" class="form-control" required multiple>
                                    </div>
                                </div>
                                <button type="button" id="addImageButton{{ $category->id }}" class="btn btn-primary" style="height: 40px; font-size: 15px; padding: 4px 8px;">Add More Images</button>
                                <div class="form-group">
                                    <label for="project_link">Project Link</label>
                                    <input type="url" name="project_link" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Post</button>
                            </form>
                        </div>
                    @endif
                    <div class="row category-row">
                            @foreach($devPosts->where('category_id', $category->id) as $index => $post)
                                <div class="col-md-10">
                                <div class="card team-member" style="height: 85%;background: rgba(224, 247, 250, 0.2);">
                                        <div class="card-body">
                                            
                                            <div class="row">
                                                
                                                @if($index % 2 == 0)
                                                    <div class="col-md-6">
                                                        <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                @foreach($post->postImages as $imageIndex => $image)
                                                                    <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                                    <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 230px;">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="dev-post">
                                        <h3>{{ $post->title }}</h3>
                                        <h5>{{ $post->subtitle }}</h5>
                                        <p style="color: white;">{{ $post->description }}</p>
                                        @if($post->project_link)
                                            <p><a href="{{ $post->project_link }}" target="_blank">Project Link</a></p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="dev-post">
                                        <h5>{{ $post->title }}</h5>
                                        <h6 style="color: #00ff99;">{{ $post->subtitle }}</h6>
                                        <p style="color: white;">{{ $post->description }}</p>
                                        @if($post->project_link)
                                            <p><a href="{{ $post->project_link }}" target="_blank">Project Link</a></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($post->postImages as $imageIndex => $image)
                                                <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 230px;">
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
                                                    </div>
                                                @endif
                                                </div>

<!-- Like, Comment, and Share Actions -->
<div class="row mt-3">
    <div class="col-md-12">
   
    <div class="post-actions d-flex justify-content-between align-items-center">
          <!-- Like and Comment Buttons -->
          <div class="d-flex align-items-center">
                <!-- Like Button and Count -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="d-inline" style="background:transparent; box-shadow: none;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;">
                        {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'Unlike' : 'Like' }} ({{ $post->likes()->count() }})
                    </button>
                </form>

 <!-- Comment Button and Modal -->
 <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#commentModal{{ $post->id }}">
                Comment ({{ $post->comments()->count() }})
            </button>
        </div>

       <!-- Comment Modal -->
<div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel{{ $post->id }}" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content glass-effect">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel{{ $post->id }}">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">{{ $post->description }}</p>
            </div>
            <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="comment" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </div>
            </form>
            <div class="modal-body">
                <h6>Comments</h6>
                @foreach($post->comments as $comment)
                    <div class="comment mt-2 p-2 border rounded" style="color: black;">
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
</div>
</div>


  <!-- Edit and Delete Buttons for the Post Author -->
  @if(Auth::id() === $userDetails->user_id)
                <div class="post-actions" style="display: flex; justify-content: flex-end; align-items: center; position: relative;">
                    <!-- Edit Button -->
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('dev_posts.edit', $post->id) }}" style="position: absolute; right: 80px; top: 50%; transform: translateY(-50%); padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; margin-top: -2%">
                        Edit
                    </a>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('dev_posts.delete', $post->id) }}" method="POST" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; background: none; box-shadow: none; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </div>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function() {
        @foreach($categories as $category)
            $('#toggleForm{{ $category->id }}').on('click', function() {
                $('#addPostForm{{ $category->id }}').toggle();
            });
            $('#addImageButton{{ $category->id }}').on('click', function() {
                $('#imageInputContainer{{ $category->id }}').append(`
                    <div class="form-group">
                        <label for="images">Images</label>
                        <input type="file" name="images[]" class="form-control" required multiple>
                    </div>
                `);
            });
        @endforeach
    });
</script>

<section>
@if(Auth::id() === $userDetails->user_id)
    <h3>Add Timeline Event</h3>
    <form action="{{ route('timeline.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="company_name">Company Name</label>
            <input type="text" name="company_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_from">Date From</label>
            <input type="date" name="date_from" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="date_to">Date To</label>
            <input type="date" name="date_to" class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Event</button>
    </form>
    @endif
</section>
<section>
    <h3>Professional Timeline</h3>
    <div class="timeline">
        @foreach($timelineEvents as $index => $event)
            <div class="timeline-event-container {{ $index % 2 == 0 ? 'even' : 'odd' }}">
                <div class="hexagon" style="background-color: {{ $colors[$index % count($colors)] }};">
                    <div class="hexagon-inner">{{ $index + 1 }}</div>
                </div>
                <div class="timeline-event">
                    <h4 class="company-name" style="color: {{ $colors[$index % count($colors)] }};">{{ $event->company_name }}</h4>
                    <p style="color:white;"><strong style="color: #ff00ff">From:</strong> {{ $event->date_from }} <br> <strong style="color:#00ff99">To:</strong> {{ $event->date_to ?? 'Present' }}</p>
                    <p style="color:white;">{{ $event->description }}</p>
                    @if(Auth::id() === $userDetails->user_id)
                    <div class="post-actions" style="display: flex; justify-content: space-between;">
                        <!-- Edit Button -->
                        <a class="btn btn-sm btn-primary" href="{{ route('timeline.edit', $event->id) }}" style="height: 30px; font-size: 15px;">Edit</a>
                        <!-- Delete Button -->
                        <form action="{{ route('timeline.destroy', $event->id) }}" method="POST" style="display: inline; background: none; box-shadow: none; margin-top: -5px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')" style="height: 30px; font-size: 15px; padding: 4px 8px;">Delete</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="zigzag-line"></div> 
    </div>
    
</section>
<section>

    <!-- Project Ideas Section -->
    <div class="mt-5">
        <h3 class="mb-3">Project Ideas</h3>
        @if(Auth::id() === $userDetails->user_id)
        <form id="projectIdeaForm" action="{{ route('profile.create_idea') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="project_idea">Project Idea</label>
                <textarea name="project_idea" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="collaboration_description">Collaboration Description</label>
                <textarea name="collaboration_description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Idea</button>
        </form>
        @endif

        <div class="ideas">
            @foreach($ideas as $idea)
                <div class="idea-card" style="margin-bottom: 20px;">
                    <div class="card-body">
                        <h3 style="color: #007bff; font-size: 22px; text-align:left;">{{ $idea->project_idea }}</h3>
                        <h6 class="card-text" style="font-size: 18px;color:white">{{ $idea->collaboration_description }}</h6>
                        
                        @if(Auth::id() != $userDetails->user_id)
                            @php
                                $collaborationRequest = $idea->collaborationRequests()->where('user_id', Auth::id())->first();
                            @endphp

                            @if($collaborationRequest)
                                @if($collaborationRequest->status == 'pending')
                                    <button class="btn btn-warning" disabled style=" font-size: 16px; padding: 4px 8px;width: 100px; margin-top:5px;">Pending</button>
                                @elseif($collaborationRequest->status == 'rejected')
                                    <button class="btn btn-danger" disabled style=" font-size: 16px; padding: 4px 8px;width: 100px; margin-top:5px;">Rejected</button>
                                @endif
                            @else
                                <form action="{{ route('collaboration.request', $idea->id) }}" method="POST" style="background:transparent; border:none; box-shadow:none;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" style=" font-size: 16px; padding: 4px 8px;width: 100px; margin-top:5px;">Request to Join</button>
                                </form>
                            @endif
                        @endif

                        @if(Auth::id() === $userDetails->user_id)
                            <div style="display: flex; justify-content: space-between;">
                                <form action="{{ route('profile.delete_idea', $idea->id) }}" method="POST" style="display: inline; background: none; box-shadow: none; margin-top: -5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this idea?')" style="height: 30px; font-size: 15px; padding: 4px 8px;">Delete</button>
                                    <a href="{{ route('profile.edit_idea', $idea->id) }}" class="btn btn-sm btn-primary" style="height: 35px; font-size: 15px; margin-top: 5px; margin-bottom: -20px;">Edit</a>
                                </form>
                            </div>
                        @endif

                        @if ($idea->workspace)
    @php
        // Check if the authenticated user is the owner of the idea
        $isOwner = $idea->user_id === Auth::id();

        // Find the collaboration request of the authenticated user for this idea
        $collaborationRequest = $idea->collaborationRequests()->where('user_id', Auth::id())->first();
    @endphp

    @if ($isOwner || ($collaborationRequest && $collaborationRequest->status == 'approved'))
        <div>
            <a href="{{ route('workspaces.show', $idea->workspace->id) }}" class="btn btn-sm btn-primary" style="font-size: 16px; padding: 4px 8px; width: 100px; margin-top: 5px;">
                View Workspace
            </a>
        </div>
    @elseif ($collaborationRequest && $collaborationRequest->status == 'pending')
        <p class="text-muted">You have a pending request for this idea.</p>
    @else
        <p class="text-muted">You don't have access to the workspace.</p>
    @endif
@else
    <p>No workspace available</p>
@endif

                    </div>
                </div>
            @endforeach
        </div>
    

            <div class="mt-4">
            @if(Auth::id() === $userDetails->user_id)
    <h3 class="mb-3">Your Achievements</h3>
    <form action="{{ route('achievements.add') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Achievement</button>
    </form>
    @endif
<h3 class="mt-4">Achievements</h3>
    <div class="achievements">
        @foreach($achievements as $achievement)
            <div class="achievement">
                <h4>{{ $achievement->achievement_title }}</h4>
                <p style="color:white">{{ $achievement->description }}</p>
                <p style="color:white">Date: {{ $achievement->date }}</p>
                @if(Auth::id() === $userDetails->user_id)
                <a href="{{ route('achievements.edit', $achievement->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('achievements.delete', $achievement->id) }}" method="POST" style="display: inline;background: none; box-shadow: none;float:left;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" style="height: 30px; font-size: 15px; padding: 4px 8px;margin-top: -20px" onclick="return confirm('Are you sure you want to delete this achievement?')">Delete</button>
        </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
</div>
                </section>
                
            @elseif($userDetails->account_type === 'Designer')
            
            <h2>Designer Profile</h2>
            <section>
    <h3>Portfolio</h3>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @foreach($designerPortfolioPosts as $post)
<div class="portfolio-post" style="display: flex; flex-wrap: wrap; margin-bottom: 30px; text-align: center;">

    <!-- Followers, Following, Posts Section -->
    <div style="flex: 100%; display: flex; justify-content: center; align-items: center; margin-top: 20px; margin-bottom: 30px;">
        <div style="flex: 1;">
            <h4>Followers</h4>
            <h5><a style="text-decoration: none; color:#00FF99" href="#" id="showFollowers" data-toggle="modal" data-target="#followersModal">{{ $followerCount }}</a></h5>
        </div>
        <div style="flex: 1;">
            <h4 style="color: white;">Following</h4>
            <h5><a style="text-decoration: none; color:#00FF99" href="#" id="showFollowing" data-toggle="modal" data-target="#followingModal">{{ $followingCount }}</a></h5>
        </div>
        <div style="flex: 1;">
            <h4 style="color: white;">Posts</h4>
            <h5>{{ $devPostCount }}</h5>
        </div>
    </div>

    <!-- Post Image -->
    @if($post->image)
    <div class="post-image" style="flex: 1 1 100%; margin-right: 20px;">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/' . $post->image))) }}" alt="{{ $post->title }}" style="width: 100%; height: 250px;">
        <div class="bubble"></div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="post-content" style="flex: 2;">
        <h4>{{ $post->title }}</h4>
        <p>{{ $post->description }}</p>
        <p>Design Tools: {{ $post->design_tools }}</p>
        <p>Design Specialization: {{ $post->design_specialization }}</p>
        <p><a href="{{ $post->link }}" target="_blank">My Best Project</a></p>

        <!-- Follow/Unfollow Button -->
        @if(auth()->user()->id !== $user->id)
            @if(auth()->user()->isFollowing($user))
                <form action="{{ route('profile.unfollow', $user->id) }}" method="POST" style="background: transparent; margin-top: 10px;  box-shadow: none;">
                    @csrf
                    <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px">Unfollow</button>
                </form>
            @else
                <form action="{{ route('profile.follow', $user->id) }}" method="POST" style="margin-top: 10px; background: transparent;  box-shadow: none;">
                    @csrf
                    <button type="submit" style="background-color: green; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px">Follow</button>
                </form>
            @endif
        @endif

        <!-- Edit Button (only visible to owner) -->
        @if(Auth::id() === $userDetails->user_id)
            <a href="{{ route('designer.portfolio.edit', $post->id) }}" class="btn btn-sm btn-primary" style="margin-top: 10px;">Edit</a>
        @endif
    </div>

</div>
@endforeach

    @if($designerPortfolioPosts->isEmpty())
        <form action="{{ route('designer.portfolio.store') }}" method="POST" enctype="multipart/form-data" id="portfolioForm">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="design_tools">Design Tools</label>
                <input type="text" name="design_tools" class="form-control" placeholder="Tools used for design">
            </div>
            <div class="form-group">
                <label for="design_specialization">Design Specialization</label>
                <input type="text" name="design_specialization" class="form-control" placeholder="Specialization in design">
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" class="form-control">
            </div>
            <div class="form-group">
                <label for="link">Project Link</label>
                <input type="url" name="link" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Portfolio Item</button>
        </form>
    @endif
</section>

    

      <!-- Within your profile page view file -->
<section>
  
    <!-- profile.blade.php -->


<div>
    <h3>Design Philosophy</h3>
    @if(Auth::id() === $userDetails->user_id)
    
<form id="designer-philosophy-form" action="{{ route('designer-philosophy.store') }}" method="POST">
        @csrf

        <!-- Other profile fields -->

        <div class="form-group">
            <label for="design_philosophy">Design Philosophy</label>
            <textarea name="design_philosophy" class="form-control">{{ $user->designPhilosophy->design_philosophy ?? '' }}</textarea>
        </div>

        <div class="form-group">
            <label for="adaptability">Adaptability</label>
            <textarea name="adaptability" class="form-control">{{ $user->designPhilosophy->adaptability ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
    @endif
    <div class="achievements">
    @if ($designPhilosophy)
    <div class="achievement">
        <p style="color:white"><strong style="color:#ff00ff">Design Philosophy:</strong> {{ $designPhilosophy->design_philosophy }}</p><br>
        <p style="color:white"><strong style="color:#ff00ff">Adaptability:</strong>{{ $designPhilosophy->adaptability }}</p>
        @if(Auth::id() === $userDetails->user_id)
        <a href="{{ route('designer-philosophy.edit', $designPhilosophy->id) }}" class="btn btn-sm btn-primary">Edit</a>
        <form action="{{ route('designer-philosophy.delete', $designPhilosophy->id) }}" method="POST" style="display: inline; background: none; box-shadow: none;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" style="height: 40px; font-size: 12px;padding: 4px 8px; float: right" onclick="return confirm('Are you sure you want to delete this design philosophy?')">Delete</button>
        </form>
        @endif
    </div>
    @else
        <p>No design philosophy added yet.</p>
    @endif
    </div>
    
</div>
</section>

<section>
@if(Auth::id() === $userDetails->user_id)
<h3>Add Skills</h3>
                    <form action="{{ route('profile.store_language_skill') }}" method="POST"  >
                        @csrf
                        <div class="form-group"  >
                            <label for="language">Software</label>
                            <input type="text" name="language" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="number" name="percentage" class="form-control" min="0" max="100" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Skill</button>
                    </form>
@endif
<h3>Software Skills</h3>
                    <div id="skillsContainer">
                        @foreach($languageSkills as $skill)
                            <div class="skill" data-percentage="{{ $skill->percentage }}" data-language="{{ $skill->language }}">
                                <div class="circle">
                                    <div class="bar"></div>
                                    <div class="box"><span>{{ $skill->percentage }}%</span></div>
                                </div>
                                <h4>{{ $skill->language }}</h4>
                                @if(Auth::id() === $userDetails->user_id)
        <form action="{{ route('profile.delete_language_skill', $skill->id) }}" method="POST" class="delete-form"style="background-color: transparent; box-shadow: none">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger delete-skill-btn" style="height: 40px; font-size: 15px;padding: 4px 8px;">Delete</button>

        </form>
        @endif
                            </div>
                        @endforeach
                    </div>
                    <section>
    @if(Auth::id() === $userDetails->user_id)
        <h3>Add Categories</h3>
        <form action="{{ route('profile.add_category') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    @endif
</section>

<section>
    <ul class="nav nav-tabs" id="categoryTabs">
        @foreach($categories as $category)
            <li class="nav-item">
                <a style="background-color: #77C4ED;" class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#category_{{ $category->id }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</section>

@if(Auth::id() === $userDetails->user_id)
    <div style="display: flex; justify-content: space-between; align-items: center;">
        @foreach($categories as $category)
            <form action="{{ route('categories.delete', $category->id) }}" method="POST" style="display: inline;background:transparent; box-shadow: none;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="height: 30px; font-size: 15px; padding: 4px 8px;" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
            </form>
        @endforeach
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        @foreach($categories as $category)
            <a class="btn btn-sm btn-primary" href="{{ route('categories.edit', $category->id) }}" style="height: 30px; font-size: 15px; padding: 4px 8px; margin-top: -15%; width: 50px;">Edit</a>
        @endforeach
    </div>
@endif

<div class="tab-content" id="categoryTabContent">
    @foreach($categories as $category)
        <div id="category_{{ $category->id }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}">
            <div class="row">
                <div class="col-md-12">
                    @if(Auth::id() === $userDetails->user_id)
                        <div class="add-post-circle">
                            <div class="circle" id="toggleForm{{ $category->id }}">
                                <img src="https://cdn-icons-png.flaticon.com/512/117/117885.png" alt="Add Icon">
                            </div>
                        </div>
                        <div class="add-post-form" id="addPostForm{{ $category->id }}" style="display: none;">
                            <h3>Add Post</h3>
                            <form action="{{ route('profile.add_post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>
                                <div id="imageInputContainer{{ $category->id }}">
                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <input type="file" name="images[]" class="form-control" required multiple>
                                    </div>
                                </div>
                                <button type="button" id="addImageButton{{ $category->id }}" class="btn btn-primary" style="height: 40px; font-size: 15px; padding: 4px 8px;">Add More Images</button>
                                <div class="form-group">
                                    <label for="project_link">Project Link</label>
                                    <input type="url" name="project_link" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Post</button>
                            </form>
                        </div>
                    @endif
                    <div class="row category-row">
                            @foreach($devPosts->where('category_id', $category->id) as $index => $post)
                                <div class="col-md-10">
                                <div class="card team-member" style="height: 85%;background: rgba(224, 247, 250, 0.2);">
                                        <div class="card-body">
                                            
                                            <div class="row">
                                                
                                                @if($index % 2 == 0)
                                                    <div class="col-md-6">
                                                        <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                @foreach($post->postImages as $imageIndex => $image)
                                                                    <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                                    <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 230px;">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="dev-post">
                                        <h5>{{ $post->title }}</h5>
                                        <h6 style="color: #00ff99;">{{ $post->subtitle }}</h6>
                                        <p style="color: white;">{{ $post->description }}</p>
                                        @if($post->project_link)
                                            <p><a href="{{ $post->project_link }}" target="_blank">Project Link</a></p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="dev-post">
                                        <h5>{{ $post->title }}</h5>
                                        <h6 style="color: #00ff99;">{{ $post->subtitle }}</h6>
                                        <p style="color: white;">{{ $post->description }}</p>
                                        @if($post->project_link)
                                            <p><a href="{{ $post->project_link }}" target="_blank">Project Link</a></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($post->postImages as $imageIndex => $image)
                                                <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 230px;">
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
                                                    </div>
                                                @endif
                                                </div>


<!-- Like, Comment, and Share Actions -->
<div class="row mt-3">
    <div class="col-md-12">
   
    <div class="post-actions d-flex justify-content-between align-items-center">
          <!-- Like and Comment Buttons -->
          <div class="d-flex align-items-center">
                <!-- Like Button and Count -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="d-inline" style="background:transparent; box-shadow: none;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;">
                        {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'Unlike' : 'Like' }} ({{ $post->likes()->count() }})
                    </button>
                </form>

 <!-- Comment Button and Modal -->
 <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#commentModal{{ $post->id }}">
                Comment ({{ $post->comments()->count() }})
            </button>
        </div>

       <!-- Comment Modal -->
<div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel{{ $post->id }}" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content glass-effect">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel{{ $post->id }}">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">{{ $post->description }}</p>
            </div>
            <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="comment" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </div>
            </form>
            <div class="modal-body">
                <h6>Comments</h6>
                @foreach($post->comments as $comment)
                    <div class="comment mt-2 p-2 border rounded" style="color: black;">
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
</div>
</div>


  <!-- Edit and Delete Buttons for the Post Author -->
  @if(Auth::id() === $userDetails->user_id)
                <div class="post-actions" style="display: flex; justify-content: flex-end; align-items: center; position: relative;">
                    <!-- Edit Button -->
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('dev_posts.edit', $post->id) }}" style="position: absolute; right: 80px; top: 50%; transform: translateY(-50%); padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; margin-top: -2%">
                        Edit
                    </a>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('dev_posts.delete', $post->id) }}" method="POST" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; background: none; box-shadow: none; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </div>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function() {
        @foreach($categories as $category)
            $('#toggleForm{{ $category->id }}').on('click', function() {
                $('#addPostForm{{ $category->id }}').toggle();
            });
            $('#addImageButton{{ $category->id }}').on('click', function() {
                $('#imageInputContainer{{ $category->id }}').append(`
                    <div class="form-group">
                        <label for="images">Images</label>
                        <input type="file" name="images[]" class="form-control" required multiple>
                    </div>
                `);
            });
        @endforeach
    });
</script>

<section>

    <!-- Project Ideas Section -->
    <div class="mt-5">
        <h3 class="mb-3">Project Ideas</h3>
        @if(Auth::id() === $userDetails->user_id)
        <form id="projectIdeaForm" action="{{ route('profile.create_idea') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="project_idea">Project Idea</label>
                <textarea name="project_idea" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="collaboration_description">Collaboration Description</label>
                <textarea name="collaboration_description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Idea</button>
        </form>
        @endif

        <div class="ideas">
            @foreach($ideas as $idea)
                <div class="idea-card" style="margin-bottom: 20px;">
                    <div class="card-body">
                        <h3 style="color: #007bff; font-size: 22px; text-align:left;">{{ $idea->project_idea }}</h3>
                        <h6 class="card-text" style="font-size: 18px;color:white">{{ $idea->collaboration_description }}</h6>
                        
                        @if(Auth::id() != $userDetails->user_id)
                            @php
                                $collaborationRequest = $idea->collaborationRequests()->where('user_id', Auth::id())->first();
                            @endphp

                            @if($collaborationRequest)
                                @if($collaborationRequest->status == 'pending')
                                    <button class="btn btn-warning" disabled style=" font-size: 16px; padding: 4px 8px;width: 100px; margin-top:5px;">Pending</button>
                                @elseif($collaborationRequest->status == 'rejected')
                                    <button class="btn btn-danger" disabled style=" font-size: 16px; padding: 4px 8px;width: 100px; margin-top:5px;">Rejected</button>
                                @endif
                            @else
                                <form action="{{ route('collaboration.request', $idea->id) }}" method="POST" style="background:transparent; border:none; box-shadow:none;">
                                    @csrf
                                    <button type="submit" class="btn btn-success" style=" font-size: 16px; padding: 4px 8px;width: 100px; margin-top:5px;">Request to Join</button>
                                </form>
                            @endif
                        @endif

                        @if(Auth::id() === $userDetails->user_id)
                            <div style="display: flex; justify-content: space-between;">
                                <form action="{{ route('profile.delete_idea', $idea->id) }}" method="POST" style="display: inline; background: none; box-shadow: none; margin-top: -5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this idea?')" style="height: 30px; font-size: 15px; padding: 4px 8px;">Delete</button>
                                    <a href="{{ route('profile.edit_idea', $idea->id) }}" class="btn btn-sm btn-primary" style="height: 35px; font-size: 15px; margin-top: 5px; margin-bottom: -20px;">Edit</a>
                                </form>
                            </div>
                        @endif

                        @if ($idea->workspace)
    @if(isset($collaborationRequest) && $collaborationRequest && $collaborationRequest->status == 'approved')
        <div>
            <a href="{{ route('workspaces.show', $idea->workspace->id) }}" class="btn btn-sm btn-primary" style="font-size: 16px; padding: 4px 8px; width: 100px; margin-top: 5px;">
                View Workspace
            </a>
        </div>
    @else
        <p class="text-muted">You don't have access to the workspace.</p>
    @endif
@else
    <p>No workspace available</p>
@endif

                    </div>
                </div>
            @endforeach
        </div>
    

   <div class="mt-4">
            @if(Auth::id() === $userDetails->user_id)
    <h3 class="mb-3">Your Achievements</h3>
    <form action="{{ route('achievements.add') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Achievement</button>
    </form>
@endif
<h3>Achievements</h3>
    <div class="achievements">
        @foreach($achievements as $achievement)
            <div class="achievement">
                <h4>{{ $achievement->achievement_title }}</h4>
                <p style="color:white">{{ $achievement->description }}</p>
                <p style="color:white">Date: {{ $achievement->date }}</p>
                @if(Auth::id() === $userDetails->user_id)
                <a href="{{ route('achievements.edit', $achievement->id) }}" class="btn btn-sm btn-primary">Edit</a>
                <form action="{{ route('achievements.delete', $achievement->id) }}" method="POST" style="display: inline;background: none; box-shadow: none;float:left;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" style="height: 30px; font-size: 15px; padding: 4px 8px;margin-top: -20px" onclick="return confirm('Are you sure you want to delete this achievement?')">Delete</button>
        </form>
        @endif
            </div>
        @endforeach
    </div>
</div>
</div>
               
       

       
    </section>

            @elseif($userDetails->account_type === 'Company')
                <h2>Company Profile</h2>
                <section>
                <h3>Portfolio</h3>
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($portfolioPosts->isEmpty())
                        <form id="portfolioForm" action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Company Name</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="link">Campanies Website</label>
                                <input type="url" name="link" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="work_experience">Work Experience</label>
                                <input type="text" name="work_experience" class="form-control" placeholder="Startup or Started From">
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    @endif

                  
            @foreach($portfolioPosts as $post)
<div class="portfolio-post" style="display: flex; flex-wrap: wrap; margin-bottom: 30px; text-align: center;">

    <!-- Followers, Following, Posts Section -->
    <div style="flex: 100%; display: flex; justify-content: center; align-items: center; margin-top: 20px; margin-bottom: 30px;">
        <div style="flex: 1;">
            <h4>Followers</h4>
            <h5><a style="text-decoration: none; color:#00FF99" href="#" id="showFollowers" data-toggle="modal" data-target="#followersModal">{{ $followerCount }}</a></h5>
        </div>
        <div style="flex: 1;">
            <h4 style="color: white;">Following</h4>
            <h5><a style="text-decoration: none; color:#00FF99" href="#" id="showFollowing" data-toggle="modal" data-target="#followingModal">{{ $followingCount }}</a></h5>
        </div>
        <div style="flex: 1;">
            <h4 style="color: white;">Posts</h4>
            <h5>{{ $devPostCount }}</h5>
        </div>
    </div>

    <!-- Post Image -->
    @if($post->image)
    <div class="post-image" style="flex: 1 1 100%; margin-right: 20px;">
        <img src="{{ asset('portfolio_images/' . $post->image) }}" alt="{{ $post->title }}" style="width: 100%; height: 250px;">
        <div class="bubble"></div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="post-content" style="flex: 2;">
        <h4>{{ $post->title }}</h4>
        <p>{{ $post->description }}</p>
        <p>Work Experience: {{ $post->work_experience }}</p>
        <p><a href="{{ $post->link }}" target="_blank">My Best Project</a></p>

        <!-- Follow/Unfollow Button -->
        @if(auth()->user()->id !== $user->id)
            @if(auth()->user()->isFollowing($user))
                <form action="{{ route('profile.unfollow', $user->id) }}" method="POST" style="background: transparent; margin-top: 10px; box-shadow: none">
                    @csrf
                    <button type="submit" style="background-color: red; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px">Unfollow</button>
                </form>
            @else
                <form action="{{ route('profile.follow', $user->id) }}" method="POST" style="margin-top: 10px; background: transparent; box-shadow: none">
                    @csrf
                    <button type="submit" style="background-color: green; color: white; padding: 5px 10px; border: none; cursor: pointer; border-radius: 5px">Follow</button>
                </form>
            @endif
        @endif

        <!-- Edit Button (only visible to owner) -->
        @if(Auth::id() === $userDetails->user_id)
            <a href="{{ route('portfolio.edit', $post->id) }}" class="btn btn-sm btn-primary" style="margin-top: 10px;">Edit</a>
        @endif
    </div>

</div>
@endforeach
<!-- resources/views/portfolio/edit.blade.php -->

<section>
    @if(Auth::id() === $userDetails->user_id)
        <h3>Add Categories</h3>
        <form action="{{ route('profile.add_category') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" name="category_name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    @endif
</section>

<section>
    <ul class="nav nav-tabs" id="categoryTabs">
        @foreach($categories as $category)
            <li class="nav-item">
                <a style="background-color: #77C4ED;" class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#category_{{ $category->id }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>
</section>

@if(Auth::id() === $userDetails->user_id)
    <div style="display: flex; justify-content: space-between; align-items: center;">
        @foreach($categories as $category)
            <form action="{{ route('categories.delete', $category->id) }}" method="POST" style="display: inline;background:transparent; box-shadow: none;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" style="height: 30px; font-size: 15px; padding: 4px 8px;" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
            </form>
        @endforeach
    </div>
    <div style="display: flex; justify-content: space-between; align-items: center;">
        @foreach($categories as $category)
            <a class="btn btn-sm btn-primary" href="{{ route('categories.edit', $category->id) }}" style="height: 30px; font-size: 15px; padding: 4px 8px; margin-top: -15%; width: 50px;">Edit</a>
        @endforeach
    </div>
@endif

<div class="tab-content" id="categoryTabContent">
    @foreach($categories as $category)
        <div id="category_{{ $category->id }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}">
            <div class="row">
                <div class="col-md-12">
                    @if(Auth::id() === $userDetails->user_id)
                        <div class="add-post-circle">
                            <div class="circle" id="toggleForm{{ $category->id }}">
                                <img src="https://cdn-icons-png.flaticon.com/512/117/117885.png" alt="Add Icon">
                            </div>
                        </div>
                        <div class="add-post-form" id="addPostForm{{ $category->id }}" style="display: none;">
                            <h3>Add Post</h3>
                            <form action="{{ route('profile.add_post') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="category_id" value="{{ $category->id }}">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="subtitle">Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control" required></textarea>
                                </div>
                                <div id="imageInputContainer{{ $category->id }}">
                                    <div class="form-group">
                                        <label for="images">Images</label>
                                        <input type="file" name="images[]" class="form-control" required multiple>
                                    </div>
                                </div>
                                <button type="button" id="addImageButton{{ $category->id }}" class="btn btn-primary" style="height: 40px; font-size: 15px; padding: 4px 8px;">Add More Images</button>
                                <div class="form-group">
                                    <label for="project_link">Project Link</label>
                                    <input type="url" name="project_link" class="form-control">
                                </div>
                                <button type="submit" class="btn btn-primary">Add Post</button>
                            </form>
                        </div>
                    @endif
                    <div class="row category-row">
                            @foreach($devPosts->where('category_id', $category->id) as $index => $post)
                                <div class="col-md-10">
                                <div class="card team-member" style="height: 90%;background: rgba(224, 247, 250, 0.2);padding: 3%">
                                        <div class="card-body">
                                            
                                            <div class="row">
                                                
                                                @if($index % 2 == 0)
                                                    <div class="col-md-6">
                                                        <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                                                            <div class="carousel-inner">
                                                                @foreach($post->postImages as $imageIndex => $image)
                                                                    <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                                    <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 230px;">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="dev-post">
                                        <h3>{{ $post->title }}</h3>
                                        <h5 >{{ $post->subtitle }}</h5>
                                        <p style="color: white;">{{ $post->description }}</p>
                                        @if($post->project_link)
                                            <p><a href="{{ $post->project_link }}" target="_blank">Project Link</a></p>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <div class="dev-post">
                                        <h3>{{ $post->title }}</h3>
                                        <h5>{{ $post->subtitle }}</h5>
                                        <p style="color: white;">{{ $post->description }}</p>
                                        @if($post->project_link)
                                            <p><a href="{{ $post->project_link }}" target="_blank">Project Link</a></p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="carouselExample{{ $post->id }}" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach($post->postImages as $imageIndex => $image)
                                                <div class="carousel-item {{ $imageIndex == 0 ? 'active' : '' }}">
                                                <img class="d-block w-100 post-image" src="{{ asset($image->image_path) }}" alt="Slide {{ $imageIndex }}" style="height: 230px;">
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
                                                    </div>
                                                @endif
                                                </div>


<!-- Like, Comment, and Share Actions -->
<div class="row mt-3">
    <div class="col-md-12">
   
    <div class="post-actions d-flex justify-content-between align-items-center">
          <!-- Like and Comment Buttons -->
          <div class="d-flex align-items-center">
                <!-- Like Button and Count -->
                <form action="{{ route('posts.like', $post->id) }}" method="POST" class="d-inline" style="background:transparent; box-shadow: none;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary" style="padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;">
                        {{ $post->likes()->where('user_id', Auth::id())->exists() ? 'Unlike' : 'Like' }} ({{ $post->likes()->count() }})
                    </button>
                </form>

 <!-- Comment Button and Modal -->
 <button type="button" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#commentModal{{ $post->id }}">
                Comment ({{ $post->comments()->count() }})
            </button>
        </div>

       <!-- Comment Modal -->
<div class="modal fade" id="commentModal{{ $post->id }}" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel{{ $post->id }}" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content glass-effect">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel{{ $post->id }}">Add Comment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">{{ $post->description }}</p>
            </div>
            <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="comment">Comment</label>
                        <textarea name="comment" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Comment</button>
                </div>
            </form>
            <div class="modal-body">
                <h6>Comments</h6>
                @foreach($post->comments as $comment)
                    <div class="comment mt-2 p-2 border rounded" style="color: black;">
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
</div>
</div>


  <!-- Edit and Delete Buttons for the Post Author -->
  @if(Auth::id() === $userDetails->user_id)
                <div class="post-actions" style="display: flex; justify-content: flex-end; align-items: center; position: relative;">
                    <!-- Edit Button -->
                    <a class="btn btn-sm btn-primary mr-2" href="{{ route('dev_posts.edit', $post->id) }}" style="position: absolute; right: 80px; top: 50%; transform: translateY(-50%); padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; margin-top: -2%">
                        Edit
                    </a>
                    
                    <!-- Delete Button -->
                    <form action="{{ route('dev_posts.delete', $post->id) }}" method="POST" style="position: absolute; right: 0; top: 50%; transform: translateY(-50%); padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem; background: none; box-shadow: none; margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="padding: 0.25rem 0.5rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.2rem;" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                    </form>
                </div>
            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    $(document).ready(function() {
        @foreach($categories as $category)
            $('#toggleForm{{ $category->id }}').on('click', function() {
                $('#addPostForm{{ $category->id }}').toggle();
            });
            $('#addImageButton{{ $category->id }}').on('click', function() {
                $('#imageInputContainer{{ $category->id }}').append(`
                    <div class="form-group">
                        <label for="images">Images</label>
                        <input type="file" name="images[]" class="form-control" required multiple>
                    </div>
                `);
            });
        @endforeach
    });
</script>

<section>
@if(Auth::id() === $userDetails->user_id)
        <h3>Add Team Members</h3>
        
        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="position">Role</label>
                <input type="text" name="role" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea name="bio" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" name="photo" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Add Team Member</button>
        </form>
    @endif
    </section>
@if(isset($teamMembers) && count($teamMembers) > 0)
<div class="team-section">
    <h2>Our Team</h2>
    <div id="teamCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($teamMembers->chunk(3) as $index => $chunk)
            <div class="carousel-item @if($index == 0) active @endif">
                <div class="row">
                    @foreach($chunk as $teamMember)
                    <div class="col-md-4">
                        <div class="team-member">
                            <div class="member-photo">
                                @if ($teamMember->photo)
                               <img src="data:image/png;base64,{{ base64_encode(file_get_contents(storage_path('app/public/team_member_photos/' . basename($teamMember->photo)))) }}" alt="Photo of {{ $teamMember->name }}">

                                @else
                                <p>No photo available.</p>
                                @endif
                            </div>
                            <div class="member-info">
                                <h3>{{ $teamMember->name }}</h3>
                                <p class="role">{{ $teamMember->role }}</p>
                                <p class="bio">{{ $teamMember->bio }}</p>
                            </div>
                            @if(Auth::id() === $userDetails->user_id)
                            <div class="member-actions">
                                <a href="{{ route('profile.edit-team-member', $teamMember->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('profile.delete-team-member', $teamMember->id) }}" method="POST" style="display: inline;background: none;box-shadow: none;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this team member?')" style="height: 30px; font-size: 15px; padding: 4px 8px">Delete</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#teamCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#teamCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
@endif

<section>
@if(Auth::id() === $userDetails->user_id)
<h3>Add Skills</h3>
                    <form action="{{ route('profile.store_language_skill') }}" method="POST"  >
                        @csrf
                        <div class="form-group"  >
                            <label for="language">Services and Skills</label>
                            <input type="text" name="language" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="number" name="percentage" class="form-control" min="0" max="100" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Skill</button>
                    </form>
@endif
<h3>Our Services and Skills</h3>
                    <div id="skillsContainer">
                        @foreach($languageSkills as $skill)
                            <div class="skill" data-percentage="{{ $skill->percentage }}" data-language="{{ $skill->language }}">
                                <div class="circle">
                                    <div class="bar"></div>
                                    <div class="box"><span>{{ $skill->percentage }}%</span></div>
                                </div>
                                <h4>{{ $skill->language }}</h4>
                                @if(Auth::id() === $userDetails->user_id)
                                <form action="{{ route('profile.delete_language_skill', $skill->id) }}" method="POST" class="delete-form"style="background-color: transparent; box-shadow: none">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger delete-skill-btn" style="height: 40px; font-size: 15px;padding: 4px 8px;">Delete</button>

        </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                 </section>
                 <div class="vacancies">
    <h2>Vacancy Posts</h2>
    @if(Auth::id() === $userDetails->user_id)
        <a href="{{ route('vacancies.create') }}" class="btn btn-primary">Add New Vacancy</a>
        <a href="{{ route('vacancies.index') }}" class="btn btn-secondary">View All Vacancies</a>
    @endif
    <div class="mt-4">
        @if($recentVacancies->isEmpty())
            <p>No recent vacancies available.</p>
        @else
            <ul class="list-group">
                @foreach($recentVacancies as $vacancy)
                    <li class="list-group-item team-member" style="background: rgba(224, 247, 250, 0.2);">
                        <h3>{{ $vacancy->title }}</h3>
                        <p>{{ Str::limit($vacancy->description, 100) }}</p>
                        <a href="{{ route('vacancies.show', $vacancy->id) }}" class="btn btn-info">View Details</a>
                        @if(Auth::id() === $vacancy->user_id)
                            <a href="{{ route('vacancies.applications', $vacancy->id) }}" class="btn btn-warning">View Applications</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<section>
    <div class="mt-4">
        @if(Auth::id() === $userDetails->user_id)
            <h3 class="mb-3">Your Achievements</h3>
            <form action="{{ route('achievements.add') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Add Achievement</button>
            </form>
        @endif
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <h3>Achievements</h3>
        <div class="achievements">
            @foreach($achievements as $achievement)
                <div class="achievement" style="background: rgba(224, 247, 250, 0.2);">
                    <h4>{{ $achievement->achievement_title }}</h4>
                    <p style="color: white">{{ $achievement->description }}</p>
                    <p>Date: {{ $achievement->date }}</p>
                    @if(Auth::id() === $userDetails->user_id)
                    <a href="{{ route('achievements.edit', $achievement->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('achievements.delete', $achievement->id) }}" method="POST" style="display: inline;background: none; box-shadow: none;float:left;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" style="height: 30px; font-size: 15px; padding: 4px 8px;margin-top: -20px" onclick="return confirm('Are you sure you want to delete this achievement?')">Delete</button>
                    </form>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>

            @else
                <p>General profile content goes here.</p>
            @endif
        @else
            <p>No profile found. Please set up your profile.</p>
        @endif
    </div>
</div>


<div id="loader" style="display:none;">
    <div class="spinner-border text-primary" role="status">
        <span class="sr-only">Loading...</span>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
      document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById('portfolioForm');
        form.addEventListener('submit', function() {
            form.style.display = 'none'; 
            const loader = document.createElement('div');
            loader.classList.add('loader');
            document.body.appendChild(loader);
        });
    });


    document.addEventListener('DOMContentLoaded', function () {
    const skills = document.querySelectorAll('.skill');

    skills.forEach(skill => {
        const percentage = skill.getAttribute('data-percentage');
        const circle = skill.querySelector('.circle');
        const bar = circle.querySelector('.bar');
        const box = circle.querySelector('.box');

        let color;

        if (percentage > 90) {
            color = '#ff00ff'; 
        } else if (percentage >= 70) {
            color = '#00ff99'; 
        } else if (percentage >= 50) {
            color = '#00ccff'; 
        } else {
            color = '#FF3131'; 
        }

        circle.style.background = `conic-gradient(${color} ${percentage * 3.6}deg, #cadcff ${percentage * 3.6}deg)`;
        bar.style.transform = `rotate(0deg)`;
       
    });
});
document.addEventListener('DOMContentLoaded', function () {
    const categoryTabs = document.querySelectorAll('.nav-link');
    const postForms = document.querySelectorAll('.add-post-form');

    categoryTabs.forEach((tab) => {
        tab.addEventListener('click', () => {
           
            postForms.forEach(form => {
                form.style.display = 'none';
            });

           
            const categoryId = tab.getAttribute('href').substring(1);
            const postForm = document.querySelector(`#${categoryId} .add-post-form`);
            if (postForm) {
                postForm.style.display = 'block';
            }
        });
    });

 
    const addPostCircles = document.querySelectorAll('#toggleForm');
    addPostCircles.forEach(circle => {
        circle.addEventListener('click', (event) => {
            const categoryId = event.target.closest('.tab-pane').id;
            const addPostForm = document.querySelector(`#${categoryId} .add-post-form`);
            if (addPostForm.style.display === 'block') {
                addPostForm.style.display = 'none';
            } else {
                addPostForm.style.display = 'block';
            }
        });
    });
    const addImageButton = document.getElementById('addImageButton');
        const imageInputContainer = document.getElementById('imageInputContainer');

        addImageButton.addEventListener('click', function () {
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'images[]';
            newInput.className = 'form-control';
            newInput.setAttribute('multiple', 'multiple');
            
            const newInputGroup = document.createElement('div');
            newInputGroup.className = 'form-group';
            newInputGroup.appendChild(newInput);

            imageInputContainer.appendChild(newInputGroup);
        });

  
const portfolioPostForm = document.getElementById('portfolioPostForm');

portfolioPostForm.addEventListener('submit', function(event) {
    event.preventDefault(); 
    if (success) {
        portfolioPostForm.style.display = 'none'; 
        alert('Portfolio post submitted successfully!'); 
    }
});

});

</script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    function showHideElements() {
        let accountType = "{{ Auth::user()->account_type }}";

        @if(isset($userDetails))
        let isOwner = "{{ Auth::id() === $userDetails->id }}";
        @else
        let isOwner = false;
        @endif

        if (isOwner) {
            document.querySelectorAll('.developer-only, .designer-only, .company-only, .general-only').forEach(element => {
                element.style.display = 'block';
            });
        } else {
            document.querySelectorAll('.developer-only, .designer-only, .company-only, .general-only').forEach(element => {
                element.style.display = 'none';
            });
        }
    }

    showHideElements();
});
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
      
        $('form[id^="commentForm"]').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var postId = form.attr('id').replace('commentForm', '');
            var modalId = '#commentModal' + postId;

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function(response) {
                    $(modalId).modal('hide');
                    location.reload();
                },
                error: function(response) {
                    alert('Error submitting comment.');
                }
            });
        });
        document.querySelectorAll('.like-comment-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;

            fetch('/toggle-like-comment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ comment_id: commentId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const likeCountSpan = this.querySelector('.like-count');
                    likeCountSpan.textContent = data.likes_count;
                    this.textContent = data.liked ? 'Unlike (' + data.likes_count + ')' : 'Like (' + data.likes_count + ')';
                }
            });
        });
    });

}); 
</script>

<script>

        document.addEventListener('DOMContentLoaded', function () {
            const showFollowersBtn = document.getElementById('showFollowers');
            const showFollowingBtn = document.getElementById('showFollowing');
            const followersList = document.getElementById('followersList');
            const followingList = document.getElementById('followingList');

            showFollowersBtn.addEventListener('click', function (e) {
                e.preventDefault();
                followersList.style.display = 'block';
                followingList.style.display = 'none'; 
            });

            showFollowingBtn.addEventListener('click', function (e) {
                e.preventDefault();
                followingList.style.display = 'block';
                followersList.style.display = 'none'; 
            });
        });
    </script>
<style>

.loader {
    border: 16px solid #f3f3f3;
    border-top: 16px solid #3498db;
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
body {
    background-color: #0d0d27;
    color: #fff;
    font-family: 'Arial', sans-serif;
}

.navbar .btn {
   display: none;
}

.container {
    max-width: 100%;
    margin: auto;
    position: relative;
}

.profile-header {
    margin-bottom: 30px;
    text-align: center;
    background-color: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
}

.profile-header h1 {
    font-size: 3rem;
    font-weight: 700;
    color: #ff00ff;
    background: linear-gradient(90deg, #ff00ff, #00ff99);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.profile-header p {
    font-size: 1.5rem;
    color: #00ff99;
}

.profile-content h2 {
    font-size: 2.5rem;
    margin-top: 30px;
    color: #ff00ff;
    text-align: center;
}

.profile-content section {
    margin-top: 20px;
}

.profile-content section h3 {
    font-size: 2rem;
    color: #00ff99;
    text-align: center;
}

.profile-content section p {
    font-size: 1.25rem;
    color: #b0b0d0;
    text-align: left;
}

.btn-primary {
    background-color: #ff00ff;
    border-color: #ff00ff;
    font-size: 1.25rem;
    padding: 10px 20px;
    display: block;
    margin: 20px auto;
    background: linear-gradient(90deg, #ff00ff, #00ff99);
    border: none;
    color: #fff;
    border-radius: 10px;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}

.btn-primary:hover {
    background-color: #e600e6;
    border-color: #e600e6;
}


.glass {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 20px;
    margin: 20px 0;
    background: rgba(255, 255, 255, 0.1);
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}


.portfolio-post {
    display: flex;
    align-items: flex-start;
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    position: relative;
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2);
}

.portfolio-post .post-content {
    flex: 1;
    margin-left: 20px; 
}

.portfolio-post .post-content h4 {
    font-size: 2rem;
    color: #ff00ff;
    font-weight: 700;
    background: linear-gradient(90deg, #ff00ff, #00ff99);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.portfolio-post .post-content p {
    font-size: 1.5rem;
    color: #b0b0d0;
}

.portfolio-post .post-content a {
    color: #00ff99;
    text-decoration: underline;
    font-weight: 500;
}

.portfolio-post .post-image {
    flex-basis: 40%;
    max-width: 40%;
    overflow: hidden;
    border-radius: 10px;
    position: relative;
}

.portfolio-post .post-image img {
    width: 100%;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

.portfolio-post .post-image:hover img {
    transform: scale(1.05);
}

.portfolio-post .bubble {
    position: absolute;
    bottom: 10px;
    left: 10px;
    width: 80px;
    height: 80px;
    background: radial-gradient(circle at 50% 50%, #ff00ff, #00ff99);
    border-radius: 50%;
    opacity: 0.5;
}

form {
    background: #181A1B;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    margin: 20px auto;
    text-align: left;
   
}

form .form-group {
    margin-bottom: 15px;
}

form .form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: #f3f3f3;
}

form .form-group input,
form .form-group textarea {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

form .form-group input[type="file"],
form .form-group input[type="url"],
form .form-group input[type="number"] {
    padding: 10px;
}

form .btn {
    background: linear-gradient(90deg, #ff00ff, #00ff99);
    border: none;
    color: #fff;
    padding: 10px 20px;
    font-size: 1.25rem;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s;
    display: block;
    margin: 0 auto;
}

form .btn:hover {
    background: linear-gradient(90deg, #e600e6, #00cc88);
}

#skillsContainer {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 20px;
    
}

.skill {
    text-align: center;
    margin: 20px;
    
}

.circle {
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    background: conic-gradient(#cadcff 0deg, #cadcff 360deg);
    box-shadow: inset 0 0 50px rgba(0, 0, 0, 0.5);
    animation: fill-bar 2s ease-in-out forwards;
}


.circle .bar,
.circle .box {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
  
}

.circle .bar {
    width: 100%;
    height: 100%;
    background: #fff;
    clip-path: polygon(0 0, 50% 0, 50% 50%, 0% 50%);
    background: transparent;
   
}

.circle .box {
    width: 110px;
    height: 110px;
    background: #fff;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 24px;
    font-weight: bold;
    background-color: #181A1B;
}

@keyframes fill-bar {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
.nav-tabs {

display: flex;

flex-wrap: wrap;

justify-content: center;

margin-bottom: 20px;

}


.nav-tabs .nav-item {

margin: 0 10px; 

}


.nav-tabs .nav-link {

background-color: #ff00ff;

color: #fff;

padding: 5px 10px;

border-radius: 5px;

transition: background 0.3s;

font-size: 1.2rem;

}


.nav-tabs .nav-link.active {

background-color: #e600e6;

}


.category-row {

display: flex;

flex-wrap: wrap;

justify-content: center;

}


.category-name {

background-color: #ff00ff;

color: #fff;

padding: 5px 10px;

margin: auto;

border-radius: 5px;

font-size: 1.3rem;

font-weight: bold;

}
.glass-card {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    padding: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    width: 100%; 
    display: flex;
    align-items: center;
}

.dev-post h5, .dev-post h6 {
    color: #ff00ff;
    font-weight: bold;
}

.dev-post p {
    color: #b0b0d0;
}

.dev-post a {
    color: #00ff99;
    text-decoration: underline;
}

.carousel-inner img {
    border-radius: 10px;
    transition: transform 0.5s ease-in-out;
    width: 100%;
    height: 230px;
    object-fit: cover;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); 
}

.carousel-inner img:hover {
    transform: scale(1.05);
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
}

.category-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.category-name {
    background-color: #ff00ff;
    color: #fff;
    padding: 5px 10px;
    margin: auto;
    border-radius: 5px;
    font-size: 1.3rem;
    font-weight: bold;
}

.carousel-item:nth-child(1) img {
    box-shadow: 0 4px 20px rgba(0, 0, 255, 0.5);
}

.carousel-item:nth-child(2) img {
    box-shadow: 0 4px 20px rgba(255, 0, 255, 0.5);
}

.carousel-item:nth-child(3) img {
    box-shadow: 0 4px 20px rgba(0, 255, 0, 0.5);
}



.add-post-circle .circle {
    width: 50px; 
    height: 50px; 
    display: flex;
    justify-content: center;
    align-items: center;
     background-color: #272A2C;;
    border-radius: 50%;
    cursor: pointer;
    transition: transform 0.3s;
    margin: auto;
    margin-top: 15px;
    margin-bottom: 15px;
}
.add-post-circle .circle img {
    width: 100%;

    
}

.add-post-form {
    display: none;
    animation: fadeInFromTop 0.5s ease-in-out;
}

@keyframes fadeInFromTop {
    0% {
        opacity: 0;
        transform: translateY(-50px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

.achievements {
    margin-top: 20px;
    flex-wrap: wrap;
}

.achievement {
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
   
}

.achievement h4 {
    color: #ff00ff;
    font-size: 1.8rem;
    margin-bottom: 10px;
   
}

.achievement p {
    color: #b0b0d0;
    font-size: 1.4rem;
    margin-bottom: 5px;
}

.achievement p:last-child {
    margin-bottom: 0;
}

.ideas {
    margin-top: 20px;
}
.idea-card {
    background-color: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px); 
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);

}

.idea-card .card-title {
    color: #ff00ff;
    font-size: 1.8rem;
    margin-bottom: 10px;
}

.idea-card .card-text {
    color: #b0b0d0;
    font-size: 1.4rem;
    margin-bottom: 5px;
}

.idea-card .btn {
    background-color: #ff00ff;
    border-color: #ff00ff;
    color: #fff;
    font-size: 1.4rem;
    border-radius: 5px;
    padding: 8px 16px;
    transition: background-color 0.3s;
}

.idea-card .btn:hover {
    background-color: #e600e6;
}
.team-section {
    background-color: transparent;
    padding: 50px 20px;
    text-align: center;
    color: #fff;
}

.team-section h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    color: #fff;
}

.carousel-inner {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    overflow: hidden;
}

.carousel-item {
    flex-basis: calc(33.33% - 20px); 
    transition: transform 0.5s ease; 
}

.team-member {
    background-color: rgba(224, 247, 250, 0.5); 
    border-radius: 10px;
    padding: 20px;
    width: 100%;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    text-align: center;
    margin-bottom: 20px; 
    transition: transform 0.3s ease;
}

.team-member:hover {
    transform: translateY(-5px); 
}

.member-photo {
    width: 100%;
    height: 200px;
    overflow: hidden;
}

.member-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover; 
    border-radius: 50%; 
}

.member-info {
    margin-top: 15px;
}

.member-info h3 {
    font-size: 1.5rem;
    color: #00796b;
    margin-bottom: 10px; 
}

.member-info .role {
    font-size: 1rem;
    color: #004d40; 
    margin-bottom: 5px; 
}

.member-info .bio {
    font-size: 0.875rem;
    color: #004d40;
    overflow: hidden; 
    text-overflow: ellipsis; 
    max-height: 60px; 
}

@media (max-width: 768px) {
    .carousel-item {
        flex-basis: calc(100% - 20px); 
    }
}
.timeline {
    display: flex;
    flex-direction: row;
    align-items: center;
    position: relative;
    margin: 20px 0;
    overflow-x: auto;
    overflow-y: hidden;
    padding-bottom: 20px;
}

.timeline-event-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    margin: 10px 20px;
    flex-shrink: 0;
    flex-basis: 300px;
    z-index: 1;
}

.timeline-event-container.odd {
    flex-direction: column-reverse;
}

.timeline-event {
    padding: 20px;
    text-align: center;
    border-radius: 10px;
    position: relative;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    width: 300px;
    transition: background-color 0.3s; 
    background-color: rgba(0, 0, 0, 0.3); 
}

.timeline-event:hover {
    background-color: rgba(255, 255, 255, 0.2); 
}

.hexagon {
    position: relative;
    width: 100px;
    height: 105.28px;
    background-color: #777;
    margin-bottom: 10px;
    margin-top: 10px;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    transform: rotate(90deg);
    overflow: hidden;
    border-radius: 10px;
}

.hexagon:before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 50%;
    height: 100%;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.3), transparent);
    transform: skewY(30deg);
}

.hexagon:after {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 50%;
    height: 100%;
    background: linear-gradient(-135deg, rgba(0, 0, 0, 0.2), transparent);
    transform: skewY(-30deg);
}

.hexagon-inner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-90deg);
    color: white;
    font-size: 24px;
    font-weight: bold;
    text-align: center;
    z-index: 1;
}

.company-name {
    color: white;
    font-weight: bold;
    border-radius: 5px;
}

/* Zigzag line styling */
.zigzag-line {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    height: 100%;
    background: none;
    z-index: 0; /* Ensure the line is behind the hexagons and events */
}

.timeline-event-container::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    border-top: 2px solid rgba(255,0,150,1);
    border-right: 2px solid rgba(255,0,150,1);
    transform: rotate(45deg);
    top: 50%;
    left: -10px;
    background: rgba(255,0,150,1);
}

.timeline-event-container.even::before {
    top: auto;
    bottom: 50%;
}

.timeline-event-container.odd::before {
    top: 50%;
    bottom: auto;
}


    /* .timeline:before {
    content: '';
    position: absolute;
    top: calc(50% - 4px);
    left: 0;
    width: 200%; 
    height: 8px; 
    background: repeating-linear-gradient(to right, red, orange, yellow, green, blue, indigo, violet); /* Use repeating-linear-gradient */
    /* z-index: -1; */

</style>
