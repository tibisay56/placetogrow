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

        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        }

        if (isset($data['site_id'])) {
            $user->sites()->sync([$data['site_id']]);
        }

        return $user;
    }
}
