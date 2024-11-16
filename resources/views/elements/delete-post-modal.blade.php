<!-- Hộp thoại Xóa Bài Viết -->
<x-jet-dialog-modal wire:model="isOpenDeletePostModal">
    <x-slot name="title">
        {{ __('Xóa Bài Viết') }}
    </x-slot>

    <x-slot name="content">
    
    <!-- Hiển thị thông báo lỗi nếu có -->
    @if(session()->has('post.error'))
    <div class="bg-red-100 border my-3 border-red-400 text-red-700 dark:bg-red-700 dark:border-red-600 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline text-center">{{ session()->get('post.error') }}</span>
    </div>
    @endif
    
    <!-- Form để xóa bài viết -->
    <form wire:submit.prevent="deletePost({{ $deletePostId }})">
        {{ __('Bạn có chắc chắn muốn xóa bài viết này không?') }}
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('isOpenDeletePostModal')" wire:loading.attr="disabled">
            {{ __('Hủy') }}
        </x-jet-secondary-button>

        <!-- Nút xác nhận xóa -->
        <button type="submit" class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition" wire:loading.attr="disabled">
            {{ __('Xóa') }}
        </button>
    </form>
    </x-slot>
</x-jet-dialog-modal>
