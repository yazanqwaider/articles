<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    /**
     * Show home page.
     */
    public function home() {
        return Inertia::render('Home');
    }
    
}
