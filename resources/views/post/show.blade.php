<x-app-layout>
    <div class="container mx-auto px-6 lg:px-32 py-10 bg-white shadow-lg rounded-lg">
        <!-- Tiêu đề bài viết -->
        <h2 class="text-4xl font-bold text-gray-800 mb-6">{{ $post->title }}</h2>
        
        <!-- Thông tin tác giả và ngày đăng -->
        <div class="flex items-center text-gray-500 mb-8">
            <span class="mr-4">Đăng bởi: <span class="text-gray-800 font-semibold">{{ $post->user->name }}</span></span>
            <span>|</span>
            <span class="ml-4">{{ $post->created_at->format('d/m/Y') }}</span>
        </div>
        
        <!-- Hiển thị hình ảnh nếu có -->
        @if($post->media->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($post->media as $media)
                    @if($media->is_image)
                        <div class="relative w-full overflow-hidden rounded-lg aspect-w-16 aspect-h-9">
                            <img src="{{ asset('storage/' . $media->path) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-full object-cover">
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
        
        <!-- Nội dung bài viết -->
        <div class="prose lg:prose-xl max-w-full mb-10">
            {!! $post->body !!}
        </div>
        
        <!-- Nút quay lại -->
        <div class="text-right">
            <a href="{{ route('posts.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full shadow-lg transition duration-300">
                Quay lại danh sách
            </a>
        </div>
    </div>
</x-app-layout>
