<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VacancyApplication extends Model
{
    use HasFactory;

    protected $table = 'vacancy_applications';
    protected $fillable = [
        'user_id',
        'vacancy_id',
        'status',
        'cv',
        'photo',
    ];

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
