<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(PostRequest $request)
    {
        try {
            $post = auth()->user()->posts()->create($request->validated());
            return response()->json([
                'status' => 'success',
                'data' => $post,
                'message' => 'Post created successfully'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Post creation failed'
            ], 500);
        }
    }

    public function index()
    {
        try {
            $posts = Post::with("user")->get();
            return response()->json([
                'status' => 'success',
                'data' => $posts,
                'message' => 'Posts retrieved successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to retrieve posts'
            ], 500);
        }
    }

    public function show(Post $post)
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => ["post" =>  $post, "user" => $post->user],
                'message' => 'Posts retrieved successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to retrieve posts'
            ], 500);
        }
    }

    public function destroy(Post $post)
    {
        try {
            $post->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Post deleted successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Failed to delete post'
            ], 500);
        }
    }
}
