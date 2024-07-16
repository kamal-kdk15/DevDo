<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
class UserController extends Controller
{
    public function index()
    {
        $users = Article::all();
        return view('vendor.adminlte.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = Article::find($id);
        return view('vendor.adminlte.users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = Article::find($id);
        return view('vendor.adminlte.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = Article::find($id);
        $user->update($request->all());
    
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }
    
    public function destroy($id)
    {
        $user = Article::find($id);
        $user->delete();
    
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
    
}
