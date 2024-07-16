<?php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;
use App\Models\DevPost;
use App\Models\PortfolioPost;
use App\Models\Category;
use App\Models\Idea;
use App\Models\CollaborationRequest;
use App\Models\DesignerPortfolioPost;
use App\Models\Achievement;
use App\Models\DesignPhilosophy;
use App\Models\TeamMember;
use App\Models\Vacancy;
use App\Models\TimelineEvent;
use App\Models\PostImage;
use App\Models\Workspace;
use App\Jobs\SendCollaborationRequestNotification;
use App\Notifications\CollaborationRequestStatusUpdated;
use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    public function setup()
    {
        return view('profile.setup');
    }

    public function updateAccountType(Request $request)
    {
        $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
        ]);

        $user = Auth::user();
        $user->update([
            'account_type_id' => $request->input('account_type_id'),
        ]);

        return redirect()->route('profile')->with('success', 'Account type updated successfully!');
    }

  

    public function showProfile($id)
    {
        $user = Article::findOrFail($id);
        
    
        $profile = Profile::where('user_id', $id)->first();
        if (!$profile) {
          
            return redirect()->route('account_type.selection'); 
        }

        $portfolioPosts = PortfolioPost::where('user_id', $id)->get();
        $designerPortfolioPosts = DesignerPortfolioPost::where('user_id', $id)->get();
        $languageSkills = DB::table('language_skills')->where('user_id', $id)->get();
        $categories = Category::where('user_id', $id)->get();
        $devPosts = DevPost::where('user_id', $id)->with('category')->get();
        $ideas = Idea::where('user_id', $id)->with('workspace')->get();
        $collaborationRequests = CollaborationRequest::whereHas('idea', function ($query) use ($id) {
            $query->where('user_id', $id);
        })->where('status', 'pending')->get();
        $achievements = Achievement::where('user_id', $id)->get();
        $designPhilosophy = DesignPhilosophy::where('user_id', $id)->first();
        $teamMembers = TeamMember::where('user_id', $id)->get();
        $recentVacancies = Vacancy::latest()->take(3)->get();
        $timelineEvents = TimelineEvent::where('user_id', $id)->get();
        $acceptedRequests = CollaborationRequest::where('user_id', $id)
                                                ->where('status', 'approved')
                                                ->get();
        $acceptedIdeas = $acceptedRequests->map(function ($request) {
            return $request->idea;
        });
        $recentVacancies = Vacancy::where('user_id', $id)->latest()->take(3)->get();
    
        $followerCount = $user->followers()->count();
        $followingCount = $user->following()->count();
        $postCount = $ideas->count();
        $devPostCount = $user->devPosts()->count();
    
        
        $followers = $user->followers()->get();
        $following = $user->following()->get();
    
        $colors = ['#1e90ff', '#ff6347', '#32cd32', '#ff69b4', '#ffa500', '#8a2be2'];
        $currentUser = Auth::user(); 
    
        return view('profile', [
            'userDetails' => $profile,
            'portfolioPosts' => $portfolioPosts,
            'designerPortfolioPosts' => $designerPortfolioPosts,
            'languageSkills' => $languageSkills,
            'devPosts' => $devPosts,
            'categories' => $categories,
            'ideas' => $ideas,
            'collaborationRequests' => $collaborationRequests,
            'achievements' => $achievements,
            'designPhilosophy' => $designPhilosophy,
            'teamMembers' => $teamMembers,
            'recentVacancies' => $recentVacancies,
            'timelineEvents' => $timelineEvents,
            'acceptedIdeas' => $acceptedIdeas,
            'colors' => $colors,
            'currentUser' => $currentUser,
            'user' => $user,
            'followerCount' => $followerCount,
            'followingCount' => $followingCount,
            'postCount' => $postCount,
            'devPostCount' => $devPostCount,
            'followers' => $followers,
            'following' => $following,
        ]);
    }
    
    public function storeLanguageSkill(Request $request)
    {
        $request->validate([
            'language' => 'required|string|max:255',
            'percentage' => 'required|integer|between:0,100',
        ]);

        DB::table('language_skills')->insert([
            'user_id' => Auth::id(),
            'language' => $request->input('language'),
            'percentage' => $request->input('percentage'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('profile.show', Auth::id())->with('success', 'Language skill added successfully!');
    }
    public function deleteLanguageSkill($id)
    {
        DB::table('language_skills')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Language skill deleted successfully!');
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->categories()->create([
            'name' => $request->input('category_name'),
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }
   
    public function editCategories()
    {
        // Fetch categories associated with the current user
        $categories = Category::where('user_id', Auth::id())->get();
        return view('edit_categories', compact('categories'));
    }


    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->category_name,
        ]);

        return redirect()->route('categories.edit')
            ->with('success', 'Category updated successfully!');
    }
    public function deleteCategory(Category $category)
    {
       
        if ($category->user_id === Auth::id()) {
            $category->delete();
            return redirect()->back()->with('success', 'Category deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'You are not authorized to delete this category.');
        }
    }
    public function addPost(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'images.*' => 'nullable|image|max:2048',
            'project_link' => 'nullable|url',
        ]);

        // Handle file uploads if images are present
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = $image->getClientOriginalName();
                $image->move(public_path('post_images'), $filename);
                $imagePaths[] = 'post_images/' . $filename;
            }
        }

        // Create the post
        $devPost = new DevPost();
        $devPost->user_id = Auth::id();
        $devPost->category_id = $request->input('category_id');
        $devPost->title = $request->input('title');
        $devPost->subtitle = $request->input('subtitle');
        $devPost->description = $request->input('description');
        $devPost->project_link = $request->input('project_link');
        $devPost->save();

        // Attach images to the post
        foreach ($imagePaths as $imagePath) {
            $devPost->postImages()->create(['image_path' => $imagePath]);
        }

        return redirect()->back()->with('success', 'Post added successfully.');
    }
    public function createIdea(Request $request)
    {
        $request->validate([
            'project_idea' => 'required|string',
            'collaboration_description' => 'nullable|string',
        ]);

        Idea::create([
            'user_id' => Auth::id(),
            'project_idea' => $request->input('project_idea'),
            'collaboration_description' => $request->input('collaboration_description'),
        ]);

        return redirect()->route('profile.show', Auth::id())->with('success', 'Project idea submitted successfully!');
    }

    public function requestCollaboration(Request $request, $ideaId)
{
    $idea = Idea::findOrFail($ideaId);

    $collaborationRequest = CollaborationRequest::create([
        'user_id' => Auth::id(),
        'idea_id' => $idea->id,
        'status' => 'pending'
    ]);

   
    $ideaOwner = $idea->user;
    $ideaOwner->notify(new \App\Notifications\CollaborationRequestReceived($collaborationRequest));

    return back()->with('message', 'Request sent successfully.');
}

public function manageRequests()
{
   
    $requests = CollaborationRequest::join('ideas', 'ideas.id', '=', 'collaboration_requests.idea_id')
        ->where('collaboration_requests.status', 'pending')
        ->where('ideas.user_id', Auth::id()) 
        ->get(['collaboration_requests.*']); 

    return view('profile.requests', compact('requests'));
}

public function respondToCollaboration(Request $request, $id, $status)
{
    
    Log::info('Incoming request', ['id' => $id, 'status' => $status]);

    try {
       
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $collaborationRequest = CollaborationRequest::findOrFail($id);

        
        if ($collaborationRequest->idea->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized action.'], 403);
        }

 
        $collaborationRequest->status = $status;
        $collaborationRequest->save();

        SendCollaborationRequestNotification::dispatch($collaborationRequest);

        if ($status === 'approved') {
            $idea = $collaborationRequest->idea;
            if (!$idea->workspace) {
                $workspace = Workspace::create([
                    'idea_id' => $idea->id,
                    'user_id' => $idea->user_id,
                ]);
            }

            $idea->workspace->users()->syncWithoutDetaching([$collaborationRequest->user_id]);
        }

        return response()->json(['success' => 'Collaboration request updated successfully.']);
    } catch (\Exception $e) {
    
        Log::error('Error responding to collaboration request: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred.'], 500);
    }
}

public function respondToRequest($id, $status)
{
    try {
        $request = CollaborationRequest::findOrFail($id);
        $request->status = $status;
        $request->save();

        Log::info("Request {$id} updated to {$status}");

        if ($status == 'approved') {
            $request->user->notify(new CollaborationRequestStatusUpdated($request));
        } elseif ($status == 'rejected') {
            $request->user->notify(new CollaborationRequestStatusUpdated($request));
        }

        return response()->json(['message' => 'Request updated successfully!']);
    } catch (\Exception $e) {
        Log::error("Error updating request {$id} to {$status}: {$e->getMessage()}");
        return response()->json(['error' => 'An error occurred while updating the request.'], 500);
    }
}
public function show($id)
{
    $userDetails = Profile::findOrFail($id);

    $ideas = Idea::where('user_id', $id)->with('collaborationRequests')->get();

    $acceptedRequests = CollaborationRequest::where('user_id', Auth::id())
                                            ->where('status', 'approved')
                                            ->pluck('idea_id'); 

    $acceptedIdeas = Idea::whereIn('id', $acceptedRequests)->get();

    return view('profile.show', compact('userDetails', 'ideas', 'acceptedIdeas'));
}


    public function editIdea($id)
    {
        $idea = Idea::findOrFail($id);
        return view('edit_idea', compact('idea'));
    }
    
    public function updateIdea(Request $request, $id)
    {
        $request->validate([
            'project_idea' => 'required|string',
            'collaboration_description' => 'nullable|string',
        ]);
    
        $idea = Idea::findOrFail($id);
        $idea->project_idea = $request->input('project_idea');
        $idea->collaboration_description = $request->input('collaboration_description');
        $idea->save();
    
        return redirect()->route('profile.show', Auth::id())->with('success', 'Project idea updated successfully!');
    }
    public function deleteIdea($id)
    {
        $idea = Idea::findOrFail($id);
        $idea->delete();
    
        return redirect()->route('profile.show', Auth::id())->with('success', 'Project idea deleted successfully!');
    }
        
  
    public function addAchievement(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $achievement = Achievement::create([
            'user_id' => auth()->id(),
            'achievement_title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        if ($achievement) {
            return redirect()->back()->with('success', 'Achievement added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add achievement.');
        }
    }
    
    public function editAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);
        return view('edit_achievement', compact('achievement'));
    }

    public function updateAchievement(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
        ]);

        $achievement = Achievement::findOrFail($id);
        $achievement->achievement_title = $request->title;
        $achievement->description = $request->description;
        $achievement->date = $request->date;
        $achievement->save();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Achievement updated successfully!');
    }

    public function deleteAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);

     
        if ($achievement->user_id != Auth::id()) {
            return redirect()->route('profile.show', Auth::id())->withErrors('Unauthorized action.');
        }

        $achievement->delete();

        return redirect()->route('profile.show', Auth::id())->with('success', 'Achievement deleted successfully!');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|string|max:255',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('team_member_photos', 'public');
        }

        $userId = Auth::id();
        $role = $request->input('role', 'worker');

        TeamMember::create([
            'user_id' => $userId,
            'name' => $request->name,
            'bio' => $request->bio,
            'photo' => $photoPath,
            'role' => $role,
        ]);

        return redirect()->back()->with('success', 'Team member added successfully.');
    }
    public function editTeamMember($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        return view('profile.edit-team-member', compact('teamMember'));
    }
    public function updateTeamMember(Request $request, $id)
    {
        $teamMember = TeamMember::findOrFail($id);
    
        $request->validate([
            'name' => 'required',
            'bio' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role' => 'nullable|string|max:255',
        ]);
    
        $teamMember->name = $request->name;
        $teamMember->bio = $request->bio;
        $teamMember->role = $request->input('role', 'worker');
    
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('team_member_photos', 'public');
            $teamMember->photo = $photoPath;
    
            // Debugging logs
            Log::info('Photo path: ' . $photoPath);
            Log::info('Stored path in DB: ' . $teamMember->photo);
        }
    
        $teamMember->save();
    
        return redirect()->route('profile.show', ['id' => Auth::id()])->with('success', 'Team member updated successfully.');
    }
    
    
    public function deleteTeamMember($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        $teamMember->delete();
        return redirect()->back()->with('success', 'Team member deleted successfully.');
    }

    public function follow(Request $request, $id)
    {
        $user = Article::findOrFail($id);

        if ($user->id !== auth()->id()) {
            auth()->user()->following()->attach($user->id, ['user_id' => auth()->id()]);
        }

        return back();
    }
    public function unfollow(Request $request, $id)
    {
        $user = Article::findOrFail($id);
    
        if ($user->id !== auth()->id()) {
            auth()->user()->following()->detach($user->id);
        }
    
        return redirect()->route('profile.show', auth()->id())->with('success', 'You have unfollowed ' . $user->name);
    }
    
        
}
