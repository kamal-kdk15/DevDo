<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\DesignerPortfolioPost;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = Article::where('name', 'LIKE', "%$query%")
                        ->where('role', '!=', 'admin')
                        ->with('portfolioPosts')
                        ->get();

       
        $designerPortfolioPosts = DesignerPortfolioPost::where('title', 'LIKE', "%$query%")
                                                      ->get();

        return view('search_results', compact('users', 'designerPortfolioPosts'));
    }
}
