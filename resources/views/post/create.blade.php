<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tạo bài viết') }}
        </h2>
    </x-slot>
   
	<livewire:posts.create />
	
</x-app-layout>