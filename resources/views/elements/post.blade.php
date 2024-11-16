<div class="flex flex-col mx-2 my-5 md:mx-6 md:my-12 lg:my-12 lg:w-2/5 lg:mx-auto">
    <div class="bg-white shadow-md rounded-3xl p-4">
        <div class="flex-none">
            <!-- Hiển thị hình ảnh hoặc video của bài viết -->
            <div class="h-full w-full mb-3 filter" wire:offline.class="grayscale">
                @foreach($post->postImages as $media)
                    @if($media->is_image && preg_match('/^.*\.(png|jpg|gif)$/i', $media->path))
                        <img src="{{ url('/storage/' . $media->path) }}" alt="Ảnh bài viết"
                             class="w-full object-scale-down md:object-cover lg:object-cover rounded-2xl" onContextMenu="return false;">
                    @elseif(!$media->is_image && preg_match('/^.*\.(mp4|3gp)$/i', $media->path))
                        <div class="container">
                            <video controls crossorigin playsinline oncontextmenu="return false;" controlsList="nodownload" class="rounded-lg filter" id="player_{{ $post->id }}">
                                <source src="{{ url('/storage/' . $media->path) }}" type="video/mp4" size="576">
                                <a href="{{ url('/storage/' . $media->path) }}" download>Tải xuống</a>
                            </video>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="flex-auto ml-3 justify-evenly py-2" wire:offline.class="text-gray-400">
                <!-- Nút xóa bài viết nếu người dùng có quyền -->
                @can('delete', $post)
                    <button id="delete_{{ $post->id }}"
                            wire:click="showDeletePostModal({{ $post->id }})"
                            class="flex float-right items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg focus:outline-none focus:shadow-outline-gray"
                            wire:offline.class="text-gray-400" aria-label="Xóa"
                            wire:loading.class="bg-gray text-gray-400" wire:offline.attr="disabled">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                @endcan

                <div class="flex flex-wrap">
                    <!-- Thông tin người đăng -->
                    <div class="w-full flex-none mb-2 text-xs text-blue-700 font-medium" wire:offline.class="text-gray-400">
                        <a href="{{ route('profile', ['username' => $post->user->username]) }}">
                            <img class="inline-block object-cover w-8 h-8 mr-1 text-white rounded-full shadow-sm cursor-pointer"
                                 src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}" />
                            Đăng bởi {{ '@' . $post->user->username }}
                        </a>
                    </div>

                    <h2 class="flex-auto text-lg font-medium">{{ $post->title }}</h2>
                </div>

                <p class="mt-3">{!! $post->body !!}</p>

                <div class="flex py-4 text-sm text-gray-600">
                    <div class="flex-1 inline-flex items-center">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <p>{{ $post->location ?? 'Không rõ' }}</p>
                    </div>
                    <div class="flex-1 inline-flex items-center">
                        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3"></path>
                        </svg>
                        <p>{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="flex space-x-3 text-sm font-medium">
                    <button wire:click="incrementLike({{ $post->id }})" class="mb-2 bg-white px-5 py-2 shadow-sm text-gray-600 rounded-full">
                        @if($post->userLikes->count())
                            <span class="text-green-400">Đã thích</span>
                        @else
                            <span class="text-gray-400">Thích</span>
                        @endif
                        <span>{{ $post->likes_count }}</span>
                    </button>
                    <button wire:click="comments({{ $post->id }})" class="bg-gray-900 px-5 py-2 text-white rounded-full hover:bg-gray-800">
                        {{ $post->comments_count }} Bình luận
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
