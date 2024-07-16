<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'user_id'];

    public function devPosts()
    {
        return $this->hasMany(DevPost::class);
    }

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id'); 
    }
}
