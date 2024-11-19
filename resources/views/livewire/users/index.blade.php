<div class="flex flex-col p-4">
  <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow-lg border border-gray-300 sm:rounded-lg rounded-xl">
        <table class="min-w-full divide-y divide-gray-300">
          <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Tên người dùng
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Tài khoản
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Thông tin
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">
                Quyền người dùng
              </th>
              <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">
                Chức năng
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach($users as $user)
            <tr class="hover:bg-gray-100 transition duration-200">
              <td class="px-6 py-4 whitespace-nowrap">
                <a href="{{ route('profile', ['username' => $user->username]) }}" class="flex items-center space-x-4">
                  <img class="h-10 w-10 rounded-full" src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                  </div>
                </a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <a href="{{ route('profile', ['username' => $user->username]) }}" class="block">
                  <div class="text-sm font-medium text-indigo-600 hover:underline">{{ '@' . $user->username }}</div>
                  <div class="text-xs text-gray-500">@if($user->is_private) Private @else Public @endif</div>
                </a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <ul class="space-y-1">
                  <li class="text-sm text-gray-900">Người theo dõi: <span class="text-green-500">{{ $user->followers_count }}</span></li>
                  <li class="text-sm text-gray-900">Đang theo dõi: <span class="text-red-500">{{ $user->followings_count }}</span></li>
                  <li class="text-sm text-gray-900">Bài viết: <span class="text-blue-500">{{ $user->posts_count }}</span></li>
                </ul>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                @if($user->role_id === 2)
                <span class="px-3 py-1 rounded-lg bg-indigo-100 text-indigo-800 font-semibold text-xs">Admin</span>
                @else
                <span class="px-3 py-1 rounded-lg bg-gray-100 text-gray-800 font-semibold text-xs">Người dùng</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex justify-center items-center">
                  <a href="{{ route('users.edit', ['user' => $user->id]) }}" class="inline-flex items-center">
                    <img src="https://res.cloudinary.com/dwfmpiozq/image/upload/v1731832226/5996831_svmwj1.png" 
                         class="h-8 w-8 hover:opacity-75 transition duration-200" 
                         alt="Edit">
                  </a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
