<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMHOZwe4lcLwtf0VgP0DPXG5QFgM1S7VoE4lp96" crossorigin="anonymous">
</head>


<x-app-layout>
    <div class="container mx-auto px-4">
        <h2 class="text-2xl font-bold mb-6">Danh sách bài viết chờ duyệt</h2>
        
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-3 border w-1/4 text-center">Tiêu đề</th>
                    <th class="px-4 py-3 border w-1/6 text-center">Tác giả</th>
                    <th class="px-4 py-3 border w-1/2 text-center">Nội dung</th>
                    <th class="px-4 py-3 border w-1/6 text-center">Ngày tạo</th>
                    <th class="px-4 py-3 border w-1/5 text-center">Chức năng </th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td class="px-4 py-3 border text-center">{{ $post->title }}</td>
                    <td class="px-4 py-3 border text-center">{{ $post->user->name }}</td>
                    <td class="px-4 py-3 border max-w-xs overflow-hidden overflow-ellipsis text-center">
                        {{ \Illuminate\Support\Str::limit($post->body, 100, '...') }}
                    </td>
                    <td class="px-4 py-3 border text-center">{{ $post->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-3 border text-center">
                        <div class="flex justify-center items-center space-x-2">
                            <!-- Nút Xem bài viết với icon -->
                            <form action="{{ route('posts.show', $post->id) }}" method="GET">
                                <button type="submit" class="flex items-center justify-center bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </form>
                        
                            <!-- Nút Phê duyệt với icon -->
                            <form action="{{ route('admin.posts.approve', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center justify-center bg-green-500 text-white p-2 rounded-full hover:bg-green-600">
                                    <i class="fas fa-check"></i>
                                </button>
                            </form>
                        
                            <!-- Nút Từ chối với icon -->
                            <form action="{{ route('admin.posts.reject', $post->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="flex items-center justify-center bg-red-500 text-white p-2 rounded-full hover:bg-red-600">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                        
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Không có bài viết chờ duyệt.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>

