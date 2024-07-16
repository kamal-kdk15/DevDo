<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignerPortfolioPost extends Model
{
    use HasFactory;
    protected $table = 'designer_portfolio_posts';

    protected $fillable = [
        'user_id',
        'title',

        'description',
        'image',
        'link',
        'design_tools',
        'design_specialization',
    ];
}
