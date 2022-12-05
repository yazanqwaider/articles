<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Articles\CreateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Articles/Create', [
            'categories' => $categories,
            'csrf' => csrf_token()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request)
    {
        $image = $request->file('preview_image')->store('articles/images');

        Auth::user()->articles()->create([
            'title'         => $request->title,
            'content'       => $request->content['blocks'],
            'preview_image' => $image,
            'category_id'   => $request->category_id
        ]);

        return Inertia::render('Welcome');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $article->load(['author', 'category']);
        return Inertia::render('Articles/Show', [
            'article' => $article
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }

    /**
     * Upload article content image.
     * 
     * @param Request $request
     */
    public function uploadArticleContentImage(Request $request) {        
        if($request->hasFile('image')) {
            $image_path = $request->file('image')->store('/articles/images/content');
            $url = Storage::url($image_path);
            return response()->json(['success' => true, 'file' => ['url' => $url]]);
        }
        return response()->json(['success' => false, 'file' => ['url' => null]]);
    }
}
