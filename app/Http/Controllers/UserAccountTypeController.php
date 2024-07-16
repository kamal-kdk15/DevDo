<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAccountType;
class UserAccountTypeController extends Controller
{
    public function store(Request $request)
    {
       
        $request->validate([
            'account_type_id' => 'required|exists:account_types,id',
        ]);

        $userId = Auth::id();

         $userAccountType = UserAccountType::updateOrCreate(
            ['user_id' => $userId],
            ['account_type_id' => $request->input('account_type_id')]
        );

        
        return redirect()->route('profile')->with('success', 'Account type selected successfully!');;
    }
}