<x-jet-action-section>
    <x-slot name="title">
        {{ __('Xác Thực Hai Yếu Tố') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Thêm bảo mật bổ sung cho tài khoản của bạn bằng cách sử dụng xác thực hai yếu tố.') }}
    </x-slot>

    <x-slot name="content">
        <h3 class="text-lg font-medium text-gray-900">
            @if ($this->enabled)
                {{ __('Bạn đã kích hoạt xác thực hai yếu tố.') }}
            @else
                {{ __('Bạn chưa kích hoạt xác thực hai yếu tố.') }}
            @endif
        </h3>

        <div class="mt-3 max-w-xl text-sm text-gray-600">
            <p>
                {{ __('Khi xác thực hai yếu tố được kích hoạt, bạn sẽ được yêu cầu nhập một mã bảo mật ngẫu nhiên trong quá trình đăng nhập. Bạn có thể lấy mã này từ ứng dụng Google Authenticator trên điện thoại của bạn.') }}
            </p>
        </div>

        @if ($this->enabled)
            @if ($showingQrCode)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Xác thực hai yếu tố đã được kích hoạt. Hãy quét mã QR sau bằng ứng dụng xác thực trên điện thoại của bạn.') }}
                    </p>
                </div>

                <div class="mt-4">
                    {!! $this->user->twoFactorQrCodeSvg() !!}
                </div>
            @endif

            @if ($showingRecoveryCodes)
                <div class="mt-4 max-w-xl text-sm text-gray-600">
                    <p class="font-semibold">
                        {{ __('Lưu trữ các mã khôi phục này trong trình quản lý mật khẩu an toàn. Các mã này có thể được sử dụng để khôi phục truy cập vào tài khoản của bạn nếu thiết bị xác thực hai yếu tố của bạn bị mất.') }}
                    </p>
                </div>

                <div class="grid gap-1 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg">
                    @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                        <div>{{ $code }}</div>
                    @endforeach
                </div>
            @endif
        @endif

        <div class="mt-5">
            @if (! $this->enabled)
                <x-jet-confirms-password wire:then="enableTwoFactorAuthentication">
                    <x-jet-button type="button" wire:loading.attr="disabled">
                        {{ __('Kích Hoạt') }}
                    </x-jet-button>
                </x-jet-confirms-password>
            @else
                @if ($showingRecoveryCodes)
                    <x-jet-confirms-password wire:then="regenerateRecoveryCodes">
                        <x-jet-secondary-button class="mr-3">
                            {{ __('Tạo Lại Mã Khôi Phục') }}
                        </x-jet-secondary-button>
                    </x-jet-confirms-password>
                @else
                    <x-jet-confirms-password wire:then="showRecoveryCodes">
                        <x-jet-secondary-button class="mr-3">
                            {{ __('Hiển Thị Mã Khôi Phục') }}
                        </x-jet-secondary-button>
                    </x-jet-confirms-password>
                @endif

                <x-jet-confirms-password wire:then="disableTwoFactorAuthentication">
                    <x-jet-danger-button wire:loading.attr="disabled">
                        {{ __('Tắt') }}
                    </x-jet-danger-button>
                </x-jet-confirms-password>
            @endif
        </div>
    </x-slot>
</x-jet-action-section>
