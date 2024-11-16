<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    
    public function index()
    {
        // Eager load quan hệ 'user' và lọc các bài viết chưa được duyệt
        $posts = Post::with('user')->where('is_approved', false)->get();
        return view('admin.posts.index', compact('posts'));
    }
    
    

    public function approve(Post $post)
    {
        $post->is_approved = true;
        $post->save();
        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã được phê duyệt!');
    }

    public function reject(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')->with('success', 'Bài viết đã bị từ chối!');
    }
}
