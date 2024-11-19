<div class="flex flex-col mx-2 my-5 md:mx-6 md:my-12 lg:my-12 lg:w-2/5 lg:mx-auto bg-white shadow-lg rounded-lg">
    <!-- Phần thông tin người dùng -->
    <div class="p-4 flex items-center">
        <!-- Thêm liên kết vào ảnh đại diện -->
        <a href="{{ route('profile', ['username' => $post->user->username]) }}" class="flex items-center">
            <img 
                class="w-10 h-10 rounded-full object-cover mr-4" 
                src="{{ asset('storage/' . $post->user->profile_photo_path) }}" 
                alt="{{ $post->user->name }}"
            >
        </a>
        <div>
            <!-- Thêm liên kết vào tên người đăng bài -->
            <a href="{{ route('profile', ['username' => $post->user->username]) }}" class="text-sm font-medium text-gray-800 hover:underline">
                {{ $post->user->name }}
            </a>
            <div class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
        </div>
    </div>
    

    <!-- Nội dung bài viết -->
    <div class="px-4">
        <h2 class="text-lg font-semibold text-gray-800">{{ $post->title }}</h2>
        <p class="text-gray-700 mt-2">{!! $post->body !!}</p>
    </div>

    <!-- Hình ảnh hoặc video -->
    @if ($post->postImages->count())
        <div class="mt-4">
            @foreach($post->postImages as $media)
                @if ($media->is_image)
                    <img src="{{ url('/storage/' . $media->path) }}" alt="Ảnh bài viết" class="w-full h-auto object-cover rounded-b-lg">
                @elseif (!$media->is_image)
                    <video controls class="w-full rounded-b-lg">
                        <source src="{{ url('/storage/' . $media->path) }}" type="video/mp4">
                        Trình duyệt của bạn không hỗ trợ video.
                    </video>
                @endif
            @endforeach
        </div>
    @endif

    <!-- Các nút hành động -->
    <div class="flex items-center justify-between p-4">
        <!-- Thích bài viết -->
        @php
        $isLiked = $post->userLikes->contains('user_id', auth()->id()); // Kiểm tra nếu người dùng đã thích
    @endphp
    <button wire:click="incrementLike({{ $post->id }})" 
            class="flex items-center {{ $isLiked ? 'text-red-600' : 'text-gray-600' }} hover:text-blue-600">
        <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
            @if ($isLiked)
                <!-- Biểu tượng trái tim đậm -->
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.344l1.172-1.172a4 4 0 115.656 5.656l-6.828 6.828a1 1 0 01-1.414 0L3.172 10.828a4 4 0 010-5.656z"></path>
            @else
                <!-- Biểu tượng trái tim rỗng -->
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.344l1.172-1.172a4 4 0 115.656 5.656l-6.828 6.828a1 1 0 01-1.414 0L3.172 10.828a4 4 0 010-5.656z"></path>
            @endif
        </svg>
        <span>{{ $post->likes_count }}</span>
    </button>

        <!-- Bình luận -->
        <button wire:click="comments({{ $post->id }})" class="flex items-center text-gray-600 hover:text-blue-600">
            <svg class="h-5 w-5 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.22 8.22 0 01-4.39-1.29l-4.81 1.2 1.2-4.81A8.22 8.22 0 013 10c0-4.418 3.582-8 8-8s8 3.582 8 8zm-9-3a1 1 0 10-2 0 1 1 0 002 0zm3 0a1 1 0 100 2 1 1 0 000-2zm3 0a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path>
            </svg>
            <span>{{ $post->comments_count }}</span>
        </button>
    </div>
</div>
