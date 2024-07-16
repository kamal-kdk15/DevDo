<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'workspace_id', 'content'];

    public function register()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }

    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
}
