<?php

namespace App\Actions\Users;

use App\Models\User;

class StoreUserAction
{
    public function execute(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->save();

        return $user;
    }
}
