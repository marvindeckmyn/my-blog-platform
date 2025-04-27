<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);

        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $validated = $request->validated();

        $request->user()->posts()->create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'slug' => Str::slug($validated['title'])
            // Note: slug doesn't guarantee uniqueness, handle later
        ]);

        return Redirect::route('posts.index')->with('success', 'Post created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePostRequest $request, Post $post)
    {
        // 1. Authorize using Policy
        $this->authorize('update', $post);

        // 2. Get Validated Data
        $validated = $request->validated();

        // 3. Update Slug
        // Note: handle later -> only if title changed
        $slug = Str::slug($validated['title']);

        // 4. Update the Post
        $post->update([...$validated, 'slug' => $slug]);

        // 5. Redirect with Success Message
        return Redirect::route('posts.index')->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Post $post)
    {
        // 1. Authorization
        $this->authorize('delete', $post);

        // 2. Delete the post
        $post->delete();

        // 3. Redirect with Success Message
        return Redirect::route('posts.index')->with('success', 'Post deleted successfully!');
    }
}
