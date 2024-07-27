<?php

namespace App\Actions\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreUserAction
{
    public function execute(array $data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make('password');
        $user->save();

        return $user;
    }
}
