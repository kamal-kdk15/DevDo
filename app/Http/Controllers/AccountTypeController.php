<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\AccountType;
use Illuminate\Support\Facades\Log;

class AccountTypeController extends Controller
{
    public function showSelectionForm()
    {
        $accountTypes = AccountType::distinct()->pluck('type');
        return view('account_type_selection', compact('accountTypes'));
    }

    public function selectAccountType(Request $request)
    {
        $request->validate([
            'account_type' => 'required|exists:account_types,type',
        ]);

        $user = Auth::user();

        if (!$user) {
            Log::error('User not authenticated');
            return redirect()->route('login')->withErrors('User not found');
        }

        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            ['account_type' => $request->input('account_type')]
        );

        return redirect()->route('profile.show', $user->id);
    }
}
