<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Article; 
class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/account-type-selection'; 

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('register'); 
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:register'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    protected function registered(Request $request, $user)
    {
        return redirect($this->redirectTo);
    }
    protected function create(array $data)
    {
        $hashedPassword = Hash::make($data['password']);
        \Log::info('Hashed Password: ' . $hashedPassword);
        return Article::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $hashedPassword,
        'password_confirmation' => $data['password_confirmation'],
        'role' => 'customer',
    ]);
    }
}
