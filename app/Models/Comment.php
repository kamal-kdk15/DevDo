<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CommentLike;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'likes_count',
    ];

    public function user()
    {
        return $this->belongsTo(Article::class);
    }

    public function post()
    {
        return $this->belongsTo(DevPost::class);
    }
    public function likes()
    {
        return $this->hasMany(CommentLike::class);
    }
    public function incrementLikesCount()
    {
        $this->update(['likes_count' => $this->likes_count + 1]);
    }

    public function decrementLikesCount()
    {
        $this->update(['likes_count' => $this->likes_count - 1]);
    }
}
