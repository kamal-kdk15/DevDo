<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;
    protected $fillable = ['dev_post_id', 'image_path'];

  
    public function devPost()
    {
        return $this->belongsTo(DevPost::class);
    }
}
