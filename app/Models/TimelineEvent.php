<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    use HasFactory;
    protected $table = 'timeline_events'; 

    protected $fillable = [
        'user_id', 'title', 'company_name', 'date_from', 'date_to', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }
}
