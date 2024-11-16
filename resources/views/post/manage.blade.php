<x-app-layout>
    <div class="container px-3 mx-auto grid bg-gray-100">
        <style>
            input, textarea, button, select, a { -webkit-tap-highlight-color: rgba(0,0,0,0); }
            button:focus { outline: 0 !important; }
        </style>

        @forelse ($posts as $post)
            <div class="post-card bg-white p-4 shadow rounded mb-4">
                <h3 class="font-bold text-lg">{{ $post->title }}</h3>
                <p>{!! $post->body !!}</p>

                <small>Được đăng {{ $post->user->username }} bởi {{ $post->created_at->format('d/m/Y') }}</small>

                @if (!$post->is_approved)
                    <div class="text-yellow-500 mt-2">Bài viết của bạn đang chờ phê duyệt.</div>
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500">Không có bài viết nào.</p>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
