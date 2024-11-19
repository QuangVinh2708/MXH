<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'user_id',
        'comment',
    ];

        public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    // Mối quan hệ đến bình luận con
    public function user()
{
    return $this->belongsTo(User::class); // Một bình luận thuộc về một người dùng
}

public function replies()
{
    return $this->hasMany(Comment::class, 'parent_id'); // Một bình luận có nhiều phản hồi
}
}
