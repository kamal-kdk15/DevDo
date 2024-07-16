<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = ['idea_id', 'user_id'];

    public function idea()
    {
        return $this->belongsTo(Idea::class);
    }

    public function user()
    {
        return $this->belongsTo(Article::class); 
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
