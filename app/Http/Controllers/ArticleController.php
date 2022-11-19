<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;

class ArticleController extends Controller
{

    public function index()
    {
        $articles = Article::all();

        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        $blogs = Blog::all();

        return view('articles.create', compact('blogs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required|min:3|max:35",
            "body" => "required|max:1000",
            "published_at" => "required",
            "blog_id" => "required",
        ]);

        $article = new Article();
        $article->title = $request->title;
        $article->body = $request->body;
        $article->published_at = $request->published_at;
        $article->blog_id = $request->blog_id;
        $article->save();

        return redirect("/home")->with("success","Article created successfully!");
    }

    public function show(Article $article)
    {
        $blogs = Cache::get("blogs");

        return view("articles.show", compact("article", "blogs"));
    }

    public function edit(Article $article)
    {
        return view("articles.edit", compact("article"));
    }

    public function update(Article $article, Request $request)
    {
        $request->validate([
            "title" => "required",
            "body" => "required",
        ]);

        $article->title = $request->title;
        $article->body = $request->body;
        $article->published_at = $request->published_at;
        $article->save();

        return redirect("/home")->with("success","Article updated successfully!");
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect("/home")->with("success","Article deleted successfully!");
    }

}
