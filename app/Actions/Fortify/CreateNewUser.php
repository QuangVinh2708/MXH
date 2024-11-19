<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     *
     * @return User
     */
    public function create(array $input)
{
    Validator::make($input, [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['required', 'string', 'max:255', 'unique:users'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => $this->passwordRules(),
        'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
    ], [
        'username.unique' => 'Tên người dùng này đã được sử dụng, vui lòng chọn tên khác.',
        'email.unique' => 'Email này đã được đăng ký, vui lòng chọn email khác.',
        'password' => 'Mật khẩu không hợp lệ hoặc đã bị rò rỉ, vui lòng chọn mật khẩu khác.',
        'terms.accepted' => 'Bạn cần đồng ý với điều khoản dịch vụ và chính sách bảo mật.',
    ])->validate();

    // Đặt ảnh đại diện mặc định
    $defaultAvatarPath = 'profile-photos\default.png'; // Đường dẫn đến ảnh mặc định

    return User::create([
        'name' => $input['name'],
        'role_id' => 1,
        'username' => $input['username'],
        'email' => $input['email'],
        'password' => Hash::make($input['password']),
        'profile_photo_path' => $defaultAvatarPath, // Gán ảnh đại diện mặc định
    ]);
}

}
