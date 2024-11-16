<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quản lý người dùng ') }}
        </h2>
    </x-slot>

    <livewire:users.index />
   
</x-app-layout>
