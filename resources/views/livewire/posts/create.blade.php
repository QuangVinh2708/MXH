<div class="flex flex-col sm:justify-center items-center min-h-screen bg-gradient-to-b from-gray-100 via-gray-200 to-gray-300">
    <div class="w-11/12 lg:w-3/4 md:w-full sm:max-w-md mt-6 px-8 py-6 bg-white shadow-2xl rounded-xl mb-12">
        <x-jet-validation-errors class="mb-4" />

        <form method="POST" wire:submit.prevent="submit" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <!-- Tiêu đề -->
            <div>
                <x-jet-label for="title" value="{{ __('Tiêu đề') }}" class="text-lg font-medium text-gray-700" />
                <x-jet-input
                    id="title"
                    class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3"
                    type="text"
                    wire:model.lazy="title"
                    placeholder="Nhập tiêu đề"
                />
            </div>

            <!-- Nội dung -->
            <div>
                <x-jet-label for="body" value="{{ __('Nội dung') }}" class="text-lg font-medium text-gray-700" />
                <textarea
                    rows="5"
                    class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 p-3"
                    wire:model.lazy="body"
                    placeholder="Nhập nội dung hoặc liên kết"
                ></textarea>
            </div>

            <!-- Tải lên file -->
            <div class="mt-4">
                <x-jet-label for="file" value="{{ __('Tải lên hình ảnh') }}" class="text-lg font-medium text-gray-700" />
                <div class="flex justify-center items-center bg-gray-100 p-4 rounded-lg shadow-sm">
                    <!-- Icon tải hình ảnh -->
                    <div 
                        class="cursor-pointer"
                        onclick="document.getElementById('fileInput').click()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 hover:text-green-600 transition duration-200" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm3 4a2 2 0 11-4 0 2 2 0 014 0zM3 15v-1a1 1 0 011-1h2.586a1 1 0 01.707.293l1.414 1.414a2 2 0 002.828 0L12 13.414a1 1 0 01.707-.293H15a1 1 0 011 1v1H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    
                    <!-- Input tải file (ẩn đi) -->
                    <input
                        type="file"
                        id="fileInput"
                        wire:model="file"
                        class="hidden"
                    />
                </div>
            </div>

            <!-- Hiển thị hình ảnh xem trước -->
            @if ($filePreview)
                <div class="mt-4">
                    <h3 class="text-sm text-gray-600">Hình ảnh xem trước:</h3>
                    <img src="{{ $filePreview }}" class="mt-2 rounded-lg shadow-lg" style="max-width: 100%; height: auto;" alt="Preview" />
                </div>
            @endif
            
            <!-- Nút đăng bài viết -->
            <div class="flex justify-center mt-6">
                <x-jet-button
                    class="bg-gradient-to-r from-indigo-500 to-purple-500 hover:from-purple-500 hover:to-indigo-500 text-white py-3 px-6 rounded-lg font-semibold shadow-lg transition duration-300 flex items-center space-x-2"
                >
                    <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731857069/%E1%BA%A2nh_ch%E1%BB%A5p_m%C3%A0n_h%C3%ACnh_2024-11-17_222339-removebg-preview_fj0waq.png" class="h-6 w-6">
                    <span>Đăng</span>
                </x-jet-button>
            </div>
        </form>
    </div>
</div>
