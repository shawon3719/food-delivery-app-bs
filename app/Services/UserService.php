<?php


namespace App\Services;


use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{

    /**
     * Generate username
     * @param $firstName
     * @param string $lastName
     * @return string
     */
    public function generateUserName($firstName, $lastName = '')
    {
        $userName = '';

        if ($firstName) {
            $userName .= strtolower(explode(" ", $firstName)[0]);
        }

        if ($lastName) {
            $userName .= '.' . strtolower(explode(" ", $lastName)[0]);
        }

        $countUser = User::whereRaw("user_name REGEXP '^{$userName}(\.[0-9]*)?$'")->count();

        if (($countUser + 1) > 1) {
            $suffix = $countUser + 1;
            $userName .= '.' . $suffix;
        }

        return $userName;
    }


    /**
     * @param $originalPassword
     * @return string
     */
    public function generateUserHashPassword($originalPassword)
    {
        return Hash::make($originalPassword);
    }

    /**
     * @param User $user
     * @return \stdClass|null
     */
    public function getUserInformation(User $user)
    {

        if ($user) {

            $roleName = $user->roles->pluck('name');
            $permissionList = $user->permissions->pluck('name');
            $data = new \stdClass();
            $data->id = $user->id;
            $data->user_name = $user->name ?? null;
            $data->email = $user->email;
            $data->avatar = $user->avatar;
            $data->latitude = $user->latitude;
            $data->longitude = $user->longitude;
            $data->roles = $roleName;
            $data->permissions = $permissionList;
        }

        return $data;
    }
}
