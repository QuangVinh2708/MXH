<x-jet-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Thông tin người dùng') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản của bạn.') }}
    </x-slot>

    <x-slot name="form">
        <!-- Name -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Tên người dùng') }}" />
            <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="name" class="mt-2" />
        </div>
        
        <!-- Profile Visibility -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="visibility" value="{{ __('Chế độ tài khoản') }}" />
            <select id="visibility" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" wire:model.defer="state.is_private">
                <option value="0">Công Khai</option>
                <option value="1">Riêng Tư</option>
            </select>
            <x-jet-input-error for="is_private" class="mt-2" />
        </div>

        <!-- Username -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="username" value="{{ __('Tên tài khoản') }}" />
            <x-jet-input id="username" type="text" class="mt-1 block w-full" wire:model.defer="state.username" />
            <x-jet-input-error for="username" class="mt-2" />
        </div>
        
        <!-- Email -->
        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="mt-1 block w-full" wire:model.defer="state.email" />
            <x-jet-input-error for="email" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Đã lưu.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled">
            {{ __('Lưu') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>
