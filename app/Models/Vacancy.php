<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    use HasFactory;
    protected $table = 'vacancies';
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'location',
        'type',
        'experience',
        'minimum_qualification',
    ];

    public function user()
    {
        return $this->belongsTo(Article::class, 'user_id');
    }
    public function applications()
    {
        return $this->hasMany(VacancyApplication::class);
    }
  
public function company()
{
    return $this->belongsTo(Company::class); 
}

}
