<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicProjectIdea extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'project_idea',
        'status',
    ];

 
    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }
}
