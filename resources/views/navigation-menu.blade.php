<nav x-data="{ open: false }" class="bg-[#CFE1B9] border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-2">
                <x-jet-application-mark class="block h-9 w-auto" />
            </a>

            <!-- Navigation Links -->
            <div class="flex flex-1 justify-start items-center space-x-6 ml-6">
                <!-- Trang chủ -->
                <a href="{{ route('home') }}" 
                   class="flex flex-col items-center text-[#728156] hover:text-white hover:bg-[#98A77C] px-4 py-2 rounded-lg transition duration-300"
                   :class="{ 'bg-[#98A77C] text-white': request()->routeIs('home') }">
                    <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731855959/pngtree-vector-house-icon-png-image_695726_ge39bn.jpg" alt="Trang chủ" class="h-6 w-6 mb-1">
                    <span class="text-sm font-medium">Trang chủ</span>
                </a>

                <!-- Nội dung -->
                <a href="{{ route('feeds') }}" 
                   class="flex flex-col items-center text-[#728156] hover:text-white hover:bg-[#98A77C] px-4 py-2 rounded-lg transition duration-300"
                   :class="{ 'bg-[#98A77C] text-white': request()->routeIs('feeds') }">
                    <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731855965/images_1_besih2.png" alt="Nội dung" class="h-6 w-6 mb-1">
                    <span class="text-sm font-medium">Bài viết của bạn</span>
                </a>

                <!-- Tạo bài viết -->
                <a href="{{ route('posts.create') }}" 
                   class="flex flex-col items-center text-[#728156] hover:text-white hover:bg-[#98A77C] px-4 py-2 rounded-lg transition duration-300"
                   :class="{ 'bg-[#98A77C] text-white': request()->routeIs('posts.create') }">
                    <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731856670/%E1%BA%A2nh_ch%E1%BB%A5p_m%C3%A0n_h%C3%ACnh_2024-11-17_221704-removebg-preview_xbpclr.png" alt="Tạo bài viết" class="h-6 w-6 mb-1">
                    <span class="text-sm font-medium">Tạo bài viết</span>
                </a>

                <!-- Quản lý người dùng -->
                @auth
                    @if(auth()->user()->role_id == 2)
                        <a href="{{ route('users.index') }}" 
                           class="flex flex-col items-center text-[#728156] hover:text-white hover:bg-[#98A77C] px-4 py-2 rounded-lg transition duration-300"
                           :class="{ 'bg-[#98A77C] text-white': request()->routeIs('users.index') }">
                            <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731856563/Thi%E1%BA%BFt_k%E1%BA%BF_ch%C6%B0a_c%C3%B3_t%C3%AAn-removebg-preview_mc0zly.png" alt="Quản lý người dùng" class="h-6 w-6 mb-1">
                            <span class="text-sm font-medium">QL Người dùng</span>
                        </a>

                        <a href="{{ route('admin.posts.index') }}" 
                           class="flex flex-col items-center text-[#728156] hover:text-white hover:bg-[#98A77C] px-4 py-2 rounded-lg transition duration-300"
                           :class="{ 'bg-[#98A77C] text-white': request()->routeIs('admin.posts.index') }">
                            <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731855965/images_1_besih2.png" alt="Quản lý bài viết" class="h-6 w-6 mb-1">
                            <span class="text-sm font-medium">QL Bài viết</span>
                        </a>
                    @endif
                @endauth
            </div>

            <!-- User Dropdown -->
            <div class="flex items-center ml-auto">
                <x-jet-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300">
                            <img class="h-8 w-8 rounded-full border-2 border-[#728156]" src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}" alt="{{ Auth::user()->name }}" >
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Quản lý tài khoản') }}
                        </div>
                        <x-jet-dropdown-link href="{{ route('profile.show') }}">
                            {{ __('Hồ sơ') }}
                        </x-jet-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Đăng xuất') }}
                            </x-jet-dropdown-link>
                        </form>
                    </x-slot>
                </x-jet-dropdown>
            </div>
        </div>
    </div>
</nav>
