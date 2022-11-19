<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Cache;
use App\Models\Article;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        Cache::forget("blogs");

        if (Cache::get("blogs")) {

            $blogs = Cache::get("blogs");

            return view("blogs.index", compact("blogs"))->with("message", "Cache used successfully!");
        } else {
            $blogs = Blog::with("articles")->get();
            Cache::put("blogs", $blogs);
        }

        return view("blogs.index", compact("blogs"))->with("message", "MySQL used successfully!");;
    }

    public function create()
    {
        return view("blogs.create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|min:3|max:35",
            "body" => "required|max:1000",
            "published_at" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()->all()]);
        }

        $blog = new Blog();
        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->published_at = $request->published_at;

        $blog->save();
        Cache::forget("blogs");

        return redirect("/home")->with("success", "Blog created successfully!");
    }

    public function show(Blog $blog)
    {
        return view("blogs.show", compact("blog"));
    }

    public function edit(Blog $blog)
    {
        return view("blogs.edit", compact("blog"));
    }

    public function update(Blog $blog, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|min:3|max:35",
            "body" => "required|max:1000",
            "published_at" => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()->all()]);
        }

        $blog->title = $request->title;
        $blog->body = $request->body;
        $blog->published_at = $request->published_at;
        $blog->save();

        Cache::forget("blogs");

        return redirect("/home")->with("success", "Blog updated successfully!");
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        Cache::forget("blogs");

        return redirect("/home")->with("success", "Blog deleted successfully!");
    }

    public function restoreArticles()
    {
        Article::withTrashed()->restore();

        return redirect("/home")->with("success", "Articles restored successfully!");
    }

    public function getBlog($id)
    {
        $blog = Blog::findOrFail($id);

        return response()->json([
            "blog" => $blog
        ], 200);
    }
}
