<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <!-- Hiển thị lỗi xác thực nếu có -->
        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <!-- Form đăng nhập -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Nhập email -->
            <div>
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Nhập mật khẩu -->
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('Mật khẩu') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <!-- Ghi nhớ đăng nhập -->
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-jet-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Ghi nhớ tôi') }}</span>
                </label>
            </div>

            <!-- Liên kết quên mật khẩu và nút đăng nhập -->
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Quên mật khẩu?') }}
                    </a>
                @endif

                <x-jet-button class="ml-4">
                    {{ __('Đăng nhập') }}
                </x-jet-button>
            </div>
        </form>
        
        <!-- Liên kết đăng ký tài khoản mới -->
        <x-slot name="anchor">
	        {{ __('Chưa có tài khoản?') }} <a class="underline" href="{{ route('register') }}">{{ __('Đăng ký ngay') }}</a>.
	    </x-slot>

    </x-jet-authentication-card>
</x-guest-layout>
