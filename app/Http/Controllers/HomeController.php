<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Show home page.
     */
    public function home() {
        $top_rated_articles = Article::with('category')->inRandomOrder()->take(10)->get();
        $random_articles = Article::with('category')->take(10)->get();
        
        return Inertia::render('Home', [
            'top_rated_articles' => $top_rated_articles,
            'random_articles' => $random_articles,
        ]);
    }
    
}
