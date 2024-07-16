<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaborationRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'idea_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }
}
