<div>
    <x-jet-authentication-card>
        <x-slot name="logo">
            
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" wire:submit.prevent="submit">
            @csrf
            
            <div>
                <x-jet-label for="name" value="{{ __('Họ và tên ') }}" />
                <x-jet-input id="name" class="block mt-1 w-full" type="text" name="name" wire:model.lazy="name" />
            </div>
            
            <div class="mt-4">
                <x-jet-label for="username" value="{{ __('Tên tài khoản') }}" />
                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" wire:model.lazy="username" />
            </div>
            
            <div class="mt-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" wire:model.lazy="email" />
            </div>
            
            <div class="mt-4">
                <x-jet-label for="is_private" value="{{ __('Quyền người dùng') }}" />
                <select id="is_private" class="block border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 w-full" wire:model.lazy="role_id">
                	<option value="1">Người dùng </option>
	                <option value="2">Admin</option>
                <select>
            </div>

            <div class="flex items-center justify-end mt-4">

                <x-jet-button class="ml-4">
                    {{ __('Cập nhật ') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</div>
