<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignPhilosophy extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'design_philosophy',
        'adaptability',
    ];

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }
}
