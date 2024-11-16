<div class="flex flex-col sm:justify-center items-center pt-10 bg-gray-100">
    <div class="w-11/12 lg:w-3/4 md:w-full sm:max-w-md mt-6 px-8 py-6 bg-white shadow-lg rounded-lg mb-12">
        <x-jet-validation-errors class="mb-4" />

        <form method="POST" wire:submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Tiêu đề -->
            <div>
                <x-jet-label for="title" value="{{ __('Tiêu đề') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.lazy="title" placeholder="Nhập tiêu đề" />
            </div>

            <!-- Nội dung -->
            <div>
                <x-jet-label for="body" value="{{ __('Nội dung') }}" />
                <textarea rows="5" class="block mt-1 w-full border-gray-300 rounded-md shadow focus:border-indigo-500" 
                          wire:model.lazy="body" wire:input="detectLink" placeholder="Nhập nội dung hoặc liên kết"></textarea>
            </div>

            <!-- Hiển thị bản xem trước liên kết nếu có -->
            @if($linkPreview)
                <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                    <h3 class="font-bold text-gray-800">{{ $linkPreview['title'] }}</h3>
                    <p class="text-gray-600">{{ $linkPreview['description'] }}</p>
                    <a href="{{ $linkPreview['url'] }}" target="_blank" class="text-blue-500 underline">Xem thêm</a>
                </div>
            @endif

            <!-- Tải lên file -->
            <div class="mt-4">
                <x-jet-label for="file" value="{{ __('Tải lên file') }}" />
                <input type="file" wire:model="file" class="w-full border-gray-300 rounded-md">
            </div>
            
            <div class="flex justify-end mt-6">
                <x-jet-button class="bg-indigo-600 hover:bg-indigo-700 text-white py-3 px-6 rounded-lg font-semibold">
                    {{ __('Đăng bài viết') }}
                </x-jet-button>
            </div>
        </form>
    </div>
</div>
