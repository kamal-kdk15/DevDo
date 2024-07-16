<?php
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DesignerPortfolioController;
use App\Http\Controllers\DesignerPhilosophyController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\TimelineEventController;
use App\Http\Controllers\DevPostController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\VacancyApplicationController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\ShareController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminController;

Route::get('/', [PostController::class, 'index'])->name('landing');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/register', function() {
    return view('register');
})->name('register');

Route::post('/register', function() {
    Article::create([
        'id' => request('id'),
        'name' => request('name'),
        'email' => request('email'),
        'password' => bcrypt(request('password')),
        'password_confirmation' => request('password'),
      

       
    ]);
 
      return redirect()->route('account_type.selection');
});
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/account-type-selection', [AccountTypeController::class, 'showSelectionForm'])->name('account_type.selection');
Route::post('/account-type-selection', [AccountTypeController::class, 'selectAccountType'])->name('account_type.select');
Route::middleware('auth')->group(function () {
    Route::get('/profile/setup', [ProfileController::class, 'setup'])->name('profile.setup');
    Route::post('/profile/update-account-type', [ProfileController::class, 'updateAccountType'])->name('profile.update_account_type');
    Route::post('/profile/store_language_skill', [ProfileController::class, 'storeLanguageSkill'])->name('profile.store_language_skill');
    Route::delete('/profile/delete_language_skill/{id}', [ProfileController::class, 'deleteLanguageSkill'])->name('profile.delete_language_skill');
    Route::post('/profile/add_category', [ProfileController::class, 'addCategory'])->name('profile.add_category');
Route::get('/categories', [ProfileController::class, 'editCategories'])->name('categories.edit');
Route::put('/categories/{category}', [ProfileController::class, 'updateCategory'])->name('categories.update');
Route::delete('/categories/{category}', [ProfileController::class, 'deleteCategory'])->name('categories.delete');

    Route::post('/profile/add_post', [ProfileController::class, 'addPost'])->name('profile.add_post');

    Route::get('/dev_posts/{post}/edit', [DevPostController::class, 'edit'])->name('dev_posts.edit');
    Route::put('/dev_posts/{post}', [DevPostController::class, 'update'])->name('dev_posts.update');
    Route::delete('/dev_posts/{post}', [DevPostController::class, 'destroy'])->name('dev_posts.delete');
    
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('/profile/create_idea', [ProfileController::class, 'store'])->name('profile.create_idea');
    Route::post('/profile/create-idea', [ProfileController::class, 'createIdea'])->name('profile.create_idea');
    Route::post('/profile/requests/{id}/{status}', 'ProfileController@respondToCollaboration')->name('profile.respond_to_collaboration');


    Route::get('/profile/edit-idea/{id}', [ProfileController::class, 'editIdea'])->name('profile.edit_idea');
Route::put('/profile/update-idea/{id}', [ProfileController::class, 'updateIdea'])->name('profile.update_idea');
Route::delete('/profile/delete-idea/{id}', [ProfileController::class, 'deleteIdea'])->name('profile.delete_idea');

    Route::post('/collaboration/request/{id}', [ProfileController::class, 'requestCollaboration'])->name('collaboration.request');
    Route::post('/profile/idea/{id}/request-collaboration', [ProfileController::class, 'requestCollaboration'])->name('collaboration.request');
    Route::post('/profile/collaboration/{id}/respond', [ProfileController::class, 'respondToCollaboration'])->name('collaboration.respond');
    Route::post('/collaboration/request/{idea}', [ProfileController::class, 'requestCollaboration'])->name('collaboration.request');
    Route::get('/profile/requests', [ProfileController::class, 'manageRequests'])->name('profile.requests');
    Route::post('/profile/requests/{id}/{status}', [ProfileController::class, 'respondToCollaboration'])->name('profile.handle_request');

    Route::resource('workspaces', WorkspaceController::class);
    Route::post('files', [FileController::class, 'store'])->name('files.store');
    Route::delete('files/{id}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile.show');
    Route::post('/workspaces/join', [WorkspaceController::class, 'joinWorkspace'])->name('join.workspace');
    Route::delete('/workspaces/{workspace}/files/{file}', [WorkspaceController::class, 'deleteFile'])
    ->name('workspaces.deleteFile');

    Route::post('/workspaces/{workspace}/files', [WorkspaceController::class, 'uploadFile'])
    ->name('workspaces.uploadFile');
    Route::get('/workspaces/{workspace}', [WorkspaceController::class, 'show'])->name('workspaces.show');
    Route::get('/workspaces/{workspace}/download/{file}', 'App\Http\Controllers\WorkspaceController@downloadFile')
    ->name('workspaces.downloadFile');
    Route::post('/workspaces/{workspace}/send-message', [WorkspaceController::class, 'sendMessage'])->name('workspaces.sendMessage');


    Route::resource('portfolio', PortfolioController::class);

Route::post('/designer/portfolio', [DesignerPortfolioController::class, 'store'])->name('designer.portfolio.store');
Route::get('/designer-portfolio/{id}/edit', [DesignerPortfolioController::class, 'edit'])->name('designer.portfolio.edit');
Route::put('/designer-portfolio/{id}', [DesignerPortfolioController::class, 'update'])->name('designer.portfolio.update');
Route::post('/portfolio/store', [PortfolioController::class, 'store'])->name('portfolio.store');
Route::get('/portfolio/{id}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');
Route::put('/portfolio/{id}/update', [PortfolioController::class, 'update'])->name('portfolio.update');

Route::put('/portfolio/{id}', 'PortfolioController@update')->name('portfolio.update');
Route::post('/profile/update-image', [ProfileController::class, 'updateImage'])->name('profile.updateImage');
Route::get('/portfolio/{id}/edit', [PortfolioController::class, 'edit'])->name('portfolio.edit');

Route::get('/portfolio/{id}/edit_image', 'PortfolioController@edit_image')->name('portfolio.edit_image');
// Route::post('/profile/{user}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
// Route::post('/profile/{user}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
Route::post('/profile/{id}/follow', [ProfileController::class, 'follow'])->name('profile.follow');
Route::post('/profile/{id}/unfollow', [ProfileController::class, 'unfollow'])->name('profile.unfollow');
    Route::get('/timeline/{event}/edit', [TimelineEventController::class, 'edit'])->name('timeline.edit');
    Route::put('/timeline/{event}', [TimelineEventController::class, 'update'])->name('timeline.update');
    Route::delete('/timeline/{event}', [TimelineEventController::class, 'destroy'])->name('timeline.destroy');
  
Route::post('/achievements/add', [ProfileController::class, 'addAchievement'])->name('achievements.add');
Route::delete('/achievements/delete/{id}', [ProfileController::class, 'deleteAchievement'])->name('achievements.delete');
Route::get('/achievements/edit/{id}', [ProfileController::class, 'editAchievement'])->name('achievements.edit');
Route::put('/achievements/update/{id}', [ProfileController::class, 'updateAchievement'])->name('achievements.update');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy-policy');
})->name('privacy');


Route::resource('vacancies', VacancyController::class);

Route::post('/vacancies/{id}/apply', [VacancyController::class, 'apply'])->name('vacancies.apply');
Route::post('/vacancies/{vacancy}/apply', [VacancyApplicationController::class, 'apply'])->name('vacancies.apply');
Route::get('/user/profile/{id}', [ProfileController::class, 'showProfile'])->name('user.profile');

Route::get('/applications', [VacancyApplicationController::class, 'applications'])->name('applications'); 

Route::get('applications/{application}/download-cv', [VacancyApplicationController::class, 'downloadCV'])->name('applications.download_cv');
Route::get('/vacancies/{vacancy}', [VacancyController::class, 'show'])->name('vacancies.show'); 
Route::post('/posts/{post}/like', [LikeController::class, 'likePost'])->name('posts.like');
Route::post('/posts/{post}/comment', [CommentController::class, 'addComment'])->name('posts.comment');
Route::post('/comments/{comment}/like', [CommentController::class, 'like'])->name('comments.like');
Route::post('/toggle-like-comment', [CommentLikeController::class, 'toggleLikeComment'])->middleware('auth');
Route::post('/posts/{post}/share', [ShareController::class, 'sharePost'])->name('posts.share');

Route::post('/comments/toggle-like', [CommentLikeController::class, 'toggleLikeComment'])->name('comments.toggleLike');
Route::get('/vacancies/{vacancy}/applications', [VacancyApplicationController::class, 'showApplications'])->name('vacancies.applications');

Route::post('/applications/{application}/update-status', [VacancyApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    Route::post('/timeline/store', [TimelineEventController::class, 'store'])->name('timeline.store');
    Route::post('/profile/store-timeline-event', [ProfileController::class, 'storeTimelineEvent'])->name('profile.store_timeline_event');

   
Route::post('/designer-philosophy', [DesignerPhilosophyController::class, 'store'])->name('designer-philosophy.store');
Route::get('/designer-philosophy/{id}/edit', [DesignerPhilosophyController::class, 'edit'])->name('designer-philosophy.edit');
Route::put('/designer-philosophy/{id}', [DesignerPhilosophyController::class, 'update'])->name('designer-philosophy.update');
Route::delete('/designer-philosophy/{id}', [DesignerPhilosophyController::class, 'delete'])->name('designer-philosophy.delete');

Route::get('/profile/edit-team-member/{id}', [ProfileController::class, 'editTeamMember'])->name('profile.edit-team-member');
Route::put('/profile/update-team-member/{id}', [ProfileController::class, 'updateTeamMember'])->name('profile.updateTeamMember');
Route::delete('/profile/delete-team-member/{id}', [ProfileController::class, 'deleteTeamMember'])->name('profile.delete-team-member');

Route::get('/explore', [DevPostController::class, 'explore'])->name('explore.posts');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

});

Route::get('/download/cv/{filename}', function ($filename) {
    $cvFilePath = storage_path('app/public/cv/' . $filename);

    if (file_exists($cvFilePath)) {
        return response()->download($cvFilePath);
    } else {
        abort(404, 'CV file not found.');
    }
})->name('download.cv');

Route::get('storage/portfolio_images/{filename}', function ($filename) {
    $path = storage_path('app/public/portfolio_images/' . $filename);

    if (!Storage::exists('public/portfolio_images/' . $filename)) {
        abort(404);
    }

    $file = Storage::get('public/portfolio_images/' . $filename);
    $type = Storage::mimeType('public/portfolio_images/' . $filename);

    $response = response()->make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('portfolio.image')->where('filename', '.*');


Route::get('storage/posts_images/{filename}', function ($filename) {
})->name('posts_images');
Route::get('storage/posts_images/{filename}', function ($filename) {
    $path = storage_path('app/public/posts_images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('posts_images');


Route::get('storage/uploads/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = response($file, 200)->header('Content-Type', $type);

    return $response;
})->name('uploads.images');

Route::get('team_member_photos/{filename}', function ($filename) {
    $path = storage_path('app/public/team_member_photos/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return response($file, 200)->header('Content-Type', $type);
})->name('team_member_photos');

Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    
    Route::middleware(AdminMiddleware::class)->group(function () {
        Route::get('/', [AdminLoginController::class, 'index'])->name('admin.home');
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/{id}', [UserController::class, 'show'])->name('admin.users.show');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
        Route::get('/collaboration-requests', [AdminController::class, 'collaborationRequests'])->name('admin.collaboration-requests.index');
        Route::put('/collaboration-requests/{id}/respond/{status}', [AdminController::class, 'respondToRequest'])->name('admin.collaboration-requests.respond');
        Route::get('/vacancies', [\App\Http\Controllers\Admin\VacancyController::class, 'index'])->name('admin.vacancies.index');
        Route::get('/vacancies/create', [\App\Http\Controllers\Admin\VacancyController::class, 'create'])->name('admin.vacancies.create');
        Route::post('/vacancies', [\App\Http\Controllers\Admin\VacancyController::class, 'store'])->name('admin.vacancies.store');
        Route::get('/vacancies/{vacancy}', [\App\Http\Controllers\Admin\VacancyController::class, 'show'])->name('admin.vacancies.show');
        Route::get('/vacancies/{vacancy}/edit', [\App\Http\Controllers\Admin\VacancyController::class, 'edit'])->name('admin.vacancies.edit');
        Route::put('/vacancies/{vacancy}', [\App\Http\Controllers\Admin\VacancyController::class, 'update'])->name('admin.vacancies.update');
        Route::delete('/vacancies/{vacancy}', [\App\Http\Controllers\Admin\VacancyController::class, 'destroy'])->name('admin.vacancies.destroy');
    
        Route::get('applications', [\App\Http\Controllers\Admin\VacancyApplicationController::class, 'index'])->name('applications.index');
        Route::get('applications/{application}', [\App\Http\Controllers\Admin\VacancyApplicationController::class, 'show'])->name('admin.applications.show');
        Route::put('applications/{application}/status', [\App\Http\Controllers\Admin\VacancyApplicationController::class, 'updateStatus'])->name('admin.applications.updateStatus');
        Route::delete('applications/{application}', [VacancyApplicationController::class, 'destroy'])->name('admin.applications.destroy');
        Route::resource('/workspaces', App\Http\Controllers\Admin\WorkspaceController::class);
        Route::get('/workspaces', [App\Http\Controllers\Admin\WorkspaceController::class, 'index'])->name('admin.workspaces');

        Route::get('/workspaces', [App\Http\Controllers\Admin\WorkspaceController::class, 'index'])->name('admin.workspaces.index');
    Route::get('/workspaces/{workspace}', [App\Http\Controllers\Admin\WorkspaceController::class, 'show'])->name('admin.workspaces.show');
    Route::get('/workspaces/{workspace}/edit', [App\Http\Controllers\Admin\WorkspaceController::class, 'edit'])->name('admin.workspaces.edit');
    Route::put('/workspaces/{workspace}', [App\Http\Controllers\Admin\WorkspaceController::class, 'update'])->name('admin.workspaces.update');
    Route::delete('/admin/workspaces/{workspace}', [App\Http\Controllers\Admin\WorkspaceController::class, 'destroy'])->name('admin.workspaces.destroy');

});
    
    
    });
    
       

    // Route::group(['prefix' => 'admin'], function () {
    //     Route::middleware(['auth:admin'])->group(function () {
    //         Route::get('/home', [AdminLoginController::class, 'index'])->name('admin.home');
    //     });
    // });
