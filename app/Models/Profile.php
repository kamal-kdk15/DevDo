<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $table = "profiles";

    protected $fillable = [
        'user_id',
        'account_type',
      
    ];

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id'); 
    }
}
