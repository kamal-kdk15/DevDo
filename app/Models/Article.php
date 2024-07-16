<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Traits\HasRoles;

class Article extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'register';

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_confirmation',
        'account_type_id',
        'role', 
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function accountType()
    {
        return $this->belongsTo(AccountType::class, 'account_type_id');
    }

    public function devPosts()
    {
        return $this->hasMany(DevPost::class, 'user_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'user_id');
    }

public function portfolioPosts()
{
    return $this->hasMany(PortfolioPost::class, 'user_id'); 
}


    public function designPhilosophy()
    {
        return $this->hasOne(DesignPhilosophy::class, 'user_id');
    }

    public function receivedCollaborationRequests()
    {
        return $this->hasManyThrough(CollaborationRequest::class, Idea::class, 'user_id', 'idea_id', 'id', 'id');
    }

    public function sentCollaborationRequests()
    {
        return $this->hasMany(CollaborationRequest::class, 'user_id');
    }

    public function ideas()
    {
        return $this->hasMany(Idea::class, 'user_id');
    }

    public function following()
    {
        return $this->belongsToMany(Article::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(Article::class, 'follows', 'followed_id', 'follower_id');
    }

    public function isFollowing(Article $register)
    {
        return $this->following()->where('followed_id', $register->id)->exists();
    }

    public function likedComments()
    {
        return $this->belongsToMany(Comment::class, 'comment_likes', 'user_id', 'comment_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}