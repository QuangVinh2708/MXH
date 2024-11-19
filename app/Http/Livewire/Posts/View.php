<?php

namespace App\Http\Livewire\Posts;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Auth;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;
use Livewire\WithPagination;

class View extends Component
{
    use WithPagination;

    public $comments = [];

    public $comment;

    public $type;

    public $queryType;

    public $postId;

    public $deletePostId;

    public $isOpenCommentModal = false;

    public $isOpenDeletePostModal = false;
    public $parentCommentId = null;
    public $replyingToUsername = null; // Username của người đang được phản hồi

    public function mount($type = null)
    {
        $this->queryType = $type;
    }

    public function render()
    {
        $posts = $this->setQuery();

        return view('livewire.posts.view', ['posts' => $posts]);
    }

    public function incrementLike(Post $post)
{
    $like = Like::where('user_id', Auth::id())->where('post_id', $post->id);

    if ($like->exists()) {
        $like->delete();
    } else {
        Like::create([
            'post_id' => $post->id,
            'user_id' => Auth::id(),
        ]);
    }

    // Phát sóng sự kiện cập nhật để cập nhật lại giao diện
    $this->emit('postLiked', $post->id);
}


        public function comments($post)
    {
        $post = Post::with(['comments.user'])->find($post);
        $this->postId = $post->id;
        $this->resetValidation('comment');
        $this->isOpenCommentModal = true;
        $this->setComments($post);
        return true;
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function createComment(Post $post)
    {
        $validatedData = Validator::make(
            ['comment' => $this->comment],
            ['comment' => 'required|max:5000']
        )->validate();
    
        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'comment' => $validatedData['comment'], // Lưu toàn bộ nội dung bình luận bao gồm @username
            'parent_id' => $this->parentCommentId, // Gán ID bình luận cha nếu có
        ]);
    
        // Reset trạng thái sau khi đăng bình luận
        $this->comment = '';
        $this->parentCommentId = null;
        $this->replyingToUsername = null;
    
        // Cập nhật danh sách bình luận
        $this->setComments($post);
    }
    

    
    public function replyToComment($commentId)
    {
        $comment = Comment::find($commentId);

        if ($comment) {
            $this->replyingToUsername = '@' . $comment->user->username; // Gán username vào thuộc tính
            $this->parentCommentId = $commentId; // Gán ID bình luận cha
            $this->comment = $this->replyingToUsername . ' '; // Đặt @username làm nội dung mặc định
        }
    }


    public function setComments($post)
    {
        // Eager load quan hệ 'user' để tránh lazy loading
        $this->comments = $post->comments()
            ->whereNull('parent_id') // Lọc các bình luận chính (không phải reply)
            ->with(['user', 'replies.user']) // Tải trước thông tin user và replies
            ->latest()
            ->get();
    }
    
    
    


    public function showDeletePostModal(Post $post)
    {
        $this->deletePostId = $post->id;
        $this->isOpenDeletePostModal = true;
    }

    public function deletePost(Post $post)
    {
        $response = Gate::inspect('delete', $post);

        if ($response->allowed()) {
            try {
                $post->delete();
                session()->flash('success', 'Bài viết đã xóa');
            } catch (Exception $e) {
                session()->flash('error', 'Không thể xóa bài viết');
            }
        } else {
            session()->flash('error', $response->message());
        }
        $this->isOpenDeletePostModal = false;
        return redirect()->back();
    }

    public function deleteComment(Post $post, Comment $comment)
    {
        $response = Gate::inspect('delete', [$comment, $post]);

        if ($response->allowed()) {
            $comment->delete();
            $this->isOpenCommentModal = false;
            session()->flash('success', 'Bình luận đã xóa');
        } else {
            session()->flash('comment.error', $response->message());
        }

        return redirect()->back();
    }

    private function setQuery()
    {
        if (! empty($this->queryType) && $this->queryType === 'me') {
            $posts = Post::withCount(['likes', 'comments'])->where('user_id', Auth::id())->with(['userLikes', 'postImages', 'user' => function ($query) {
                $query->select(['id', 'name', 'username', 'profile_photo_path']);
            },
            ])->latest()->paginate(10);
        } elseif (! empty($this->queryType) && $this->queryType === 'followers') {
            $userIds = Auth::user()->followings()->pluck('follower_id');
            $userIds[] = Auth::id();
            $posts = Post::withCount(['likes', 'comments'])->whereIn('user_id', $userIds)->with(['userLikes', 'postImages', 'user' => function ($query) {
                $query->select(['id', 'name', 'username', 'profile_photo_path']);
            },
            ])->latest()->paginate(10);
        } else {
            $posts = Post::withCount(['likes', 'comments'])->with(['userLikes', 'postImages', 'user' => function ($query) {
                $query->select(['id', 'name', 'username', 'profile_photo_path']);
            },
            ])->latest()->paginate(10);
        }

        return $posts;
    }


}
