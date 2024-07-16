<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevPost extends Model
{
    use HasFactory;
    protected $table = 'devposts'; 

    protected $fillable = ['user_id', 'category_id', 'title', 'subtitle', 'description', 'image', 'project_link'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }
    public function postImages()
{
    return $this->hasMany(PostImage::class);
}
public function likes()
    {
        return $this->hasMany(Like::class, 'post_id');
    }

    // Define the comments relationship
    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
    }


    public function shares()
    {
        return $this->hasMany(Share::class, 'post_id');
    }

}
