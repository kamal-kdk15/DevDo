<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $table = 'account_types'; 

    use HasFactory;
    protected $fillable = [
        'name',
        'functionalities',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_account_type');
    }
    
}
