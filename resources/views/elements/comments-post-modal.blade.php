<x-jet-dialog-modal wire:model="isOpenCommentModal">
    <x-slot name="title">
        {{ __('Comments') }}
    </x-slot>

    <x-slot name="content">
        <!-- Hiển thị thông báo lỗi nếu có -->
        @if(session()->has('comment.error'))
        <div class="bg-red-100 border my-3 border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline text-center">{{ session()->get('comment.error') }}</span>
        </div>
        @endif

        <!-- Form để tạo bình luận -->
        <form wire:submit.prevent="createComment({{ $postId }})">
            <div class="mt-4">
                <textarea 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                    rows="3"
                    wire:model.lazy="comment"
                    placeholder="{{ $replyingToUsername ? $replyingToUsername . ' ' . __('Hãy bình luận ....') : __('Hãy bình luận ....') }}">
                </textarea>
                <x-jet-input-error for="comment" class="mt-2" />
            </div>
            

            <div class="flex justify-center space-x-4 mt-4">
                <x-jet-secondary-button 
                    wire:click="$toggle('isOpenCommentModal')" 
                    wire:loading.attr="disabled" 
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2">
                    {{ __('Hủy') }}
                </x-jet-secondary-button>
            
                <x-jet-button 
                    class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2" 
                    type="submit" 
                    wire:loading.attr="disabled">
                    {{ __('Đăng') }}
                </x-jet-button>
            </div>
            
        </form>

        <!-- Hiển thị danh sách bình luận -->
        <div class="mt-6 space-y-4 max-h-60 overflow-y-auto">
            @forelse($comments as $comment)
            <div class="flex space-x-4 bg-gray-50 p-4 rounded-lg shadow-sm">
                <img 
                    class="w-10 h-10 rounded-full border-2 border-indigo-500"
                    src="{{ asset('storage/' . $comment->user->profile_photo_path) }}" 
                    alt="{{ $comment->user->name }}">
                <div class="flex-1">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                        <small class="text-gray-500">{{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="text-gray-700 mt-2">
                        {!! nl2br(e($comment->comment)) !!} <!-- Hiển thị nội dung bình luận với @username -->
                    </p>
                    <div class="flex items-center mt-2 space-x-4 text-sm text-gray-500">
                        <button wire:click="replyToComment({{ $comment->id }})" class="hover:text-blue-500">
                            {{ __('Reply') }}
                        </button>
                        <button 
                            wire:click="deleteComment({{ $post->id }}, {{ $comment->id }})"
                            class="hover:text-red-500">
                            {{ __('Delete') }}
                        </button>
                    </div>
        
                    <!-- Hiển thị các phản hồi -->
                    <div class="ml-10 mt-4 space-y-4">
                        @foreach($comment->replies as $reply)
                        <div class="flex space-x-4">
                            <img 
                                class="w-8 h-8 rounded-full border-2 border-gray-400"
                                src="{{ asset('storage/' . $reply->user->profile_photo_path) }}" 
                                alt="{{ $reply->user->name }}">
                            <div>
                                <span class="font-semibold text-gray-700">{{ $reply->user->name }}</span>
                                <small class="text-gray-500 ml-2">{{ $reply->created_at->diffForHumans() }}</small>
                                <p class="text-gray-600 mt-1">{!! nl2br(e($reply->comment)) !!}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <p class="text-center text-gray-500">{{ __('No comments found') }}</p>
            @endforelse
        </div>
        
        
    </x-slot>

    <x-slot name="footer">
        <!-- Slot footer để tránh lỗi -->
        <div></div>
    </x-slot>
</x-jet-dialog-modal>
