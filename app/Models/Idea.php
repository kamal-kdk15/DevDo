<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'developer_id', 'project_idea', 'collaboration_description', 'status', 'request_type',
    ];


public function user()
{
    return $this->belongsTo(Article::class, 'user_id');
}

public function collaborationRequests()
{
    return $this->hasMany(CollaborationRequest::class);
}

public function workspace()
{
    return $this->hasOne(Workspace::class);
}
public function collaborators()
{
    return $this->belongsToMany(User::class, 'collaborations', 'idea_id', 'user_id');
}

public function isApproved($userId)
{
    return $this->collaborationRequests()
                ->where('user_id', $userId)
                ->where('status', 'approved')
                ->exists();
}
}
