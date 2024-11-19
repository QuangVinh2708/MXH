<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Models\Post;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of approved posts for users.
     *
     * @return Application|Factory|View
     */
    public function index()
{
    // Nếu là admin, lấy tất cả bài viết (bao gồm chưa duyệt)
    // Nếu không phải admin, chỉ lấy bài viết đã duyệt
    $posts = Post::with('user')
                 ->where('is_approved', true) // Lọc bài viết đã duyệt
                 ->where('user_id', auth()->id()) // Lọc theo user hiện tại
                 ->paginate(10);
    
    return view('post.manage', compact('posts'));
}

    
    
    /**
     * Display the followers' posts.
     *
     * @return Application|Factory|View
     */
    public function followers(): Application|Factory|View
    {
        // Lấy danh sách các người dùng mà người dùng hiện tại đang theo dõi
        $followings = Auth::user()->followings()->pluck('following_id'); 
    
        // Lấy các bài viết của những người mà người dùng hiện tại theo dõi
        $posts = Post::with('user')
                     ->whereIn('user_id', $followings) // Lọc bài viết của những người theo dõi
                     ->paginate(10); // Phân trang
    
        return view('post.followers', compact('posts'));
    }
    
    /**
     * Show the form for creating a new post.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('post.create');
    }

    /**
     * Store a newly created post in the database.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Tạo một bài đăng mới và đặt is_approved = false
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'location' => $request->location,
            'body' => $request->body,
            'is_approved' => false // Bài đăng chưa được duyệt
        ]);

        return redirect()->route('posts.index')->with('message', 'Bài viết của bạn đang chờ phê duyệt.');
    }

    /**
     * Display the specified post if it is approved.
     *
     * @param Post $post
     * @return Application|Factory|View
     */
    public function show(Post $post)
    {
        // Lấy bài viết cùng với các media liên quan
        $post->load('media');
    
        // Kiểm tra nếu bài viết chưa được duyệt và người dùng không phải là admin
        if (!$post->is_approved && !Auth::user()->isAdmin()) {
            abort(403, 'Bài viết chưa được duyệt.');
        }
    
        return view('post.show', compact('post'));
    }
    


    /**
     * Show the form for editing the specified post.
     *
     * @param Post $post
     * @return Application|Factory|View
     */
    public function edit(Post $post): View|Factory|Application
    {
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified post in the database.
     *
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->only(['title', 'location', 'body']));
        return redirect()->route('posts.index')->with('message', 'Bài viết đã được cập nhật.');
    }

    /**
     * Remove the specified post from storage.
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Bài viết đã được xóa.');
    }

    /**
     * Approve the specified post (Admin only).
     *
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Post $post)
    {
        // Kiểm tra quyền admin
        if (auth()->user()->isAdmin()) {
            $post->is_approved = true; // Đánh dấu bài viết là đã được duyệt
            $post->save();
    
            return redirect()->route('admin.posts.index')->with('message', 'Bài viết đã được duyệt.');
        }
    
        abort(403, 'Bạn không có quyền truy cập.');
    }
    
    
}
