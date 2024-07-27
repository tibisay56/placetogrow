<?php

namespace App\Actions\Users;

use App\Models\User;

class UpdateUserAction
{
    public function execute(User $user, array $data): User
    {
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (isset($data['roles_id'])) {
            $user->syncRoles($data['roles_id']);
        }

        if (isset($data['site_id'])) {
            $user->sites()->sync($data['site_id']);
        }

        return $user;
    }
}
