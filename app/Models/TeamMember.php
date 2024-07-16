<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $table = 'teammembers';

    protected $fillable = [
        'user_id',
        'name',
        'role',
        'bio',
        'photo'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'user_id', 'id');
    }
}
