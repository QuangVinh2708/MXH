<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        <x-jet-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-jet-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                        {{ __('Trang chủ') }}
                    </x-jet-nav-link>
                    
                    <x-jet-nav-link href="{{ route('feeds') }}" :active="request()->routeIs('feeds')">
                        {{ __('Nội dung') }}
                    </x-jet-nav-link>
                    
                    <x-jet-nav-link href="{{ route('posts.create') }}" :active="request()->routeIs('posts.create')">
                        {{ __('Tạo bài viết ') }}
                    </x-jet-nav-link>
                    
                    <x-jet-nav-link href="{{ route('posts.index') }}" :active="request()->routeIs('posts.index')">
                        {{ __('Bài của bạn ') }}
                    </x-jet-nav-link>
                    
                    <!-- Quản lý người dùng (chỉ admin) -->
                    @can('viewAny', auth()->user())
                    <x-jet-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                        {{ __('Quản lý người dùng ') }}
                    </x-jet-nav-link>
                    @endcan

                        <!-- Quản lý bài viết (chỉ admin) -->
                @auth
                    @if(auth()->check() && auth()->user()->role_id == 2)
                        <x-jet-nav-link href="{{ route('admin.posts.index') }}" :active="request()->routeIs('admin.posts.index')">
                            {{ __('Quản lý bài viết') }}
                        </x-jet-nav-link>
                    @endif
                @endauth

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <x-jet-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-jet-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-jet-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-jet-dropdown-link href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-jet-dropdown-link>
                            </form>
                        </x-slot>
                    </x-jet-dropdown>
                </div>
            </div>

            <!-- Hamburger Menu (Responsive) -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': ! open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-jet-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
                {{ __('Trang chủ') }}
            </x-jet-responsive-nav-link>

            <x-jet-responsive-nav-link href="{{ route('feeds') }}" :active="request()->routeIs('feeds')">
                {{ __('Nội dung') }}
            </x-jet-responsive-nav-link>

            <x-jet-responsive-nav-link href="{{ route('posts.create') }}" :active="request()->routeIs('posts.create')">
                {{ __('Đăng bài viết') }}
            </x-jet-responsive-nav-link>

            <x-jet-responsive-nav-link href="{{ route('posts.index') }}">
                {{ __('Bài viết của bạn') }}
            </x-jet-responsive-nav-link>

            <!-- Quản lý bài viết (chỉ admin) trong responsive menu -->
            @auth
                @if(auth()->user()->role == 'admin')
                    <x-jet-responsive-nav-link href="{{ route('admin.posts.approval') }}" :active="request()->routeIs('admin.posts.approval')">
                        {{ __('Quản lý bài viết') }}
                    </x-jet-responsive-nav-link>
                @endif
            @endauth
        </div>
    </div>
</nav>

