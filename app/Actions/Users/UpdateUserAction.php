<?php

namespace App\Actions\Users;

use App\Models\Site;
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
            $currentSite = $user->site;
            if ($currentSite) {
                $currentSite->user_id = null;
                $currentSite->save();
            }

            $site = Site::find($data['site_id']);
            if ($site) {
                $site->user_id = $user->id;
                $site->save();
            }
        }

        return $user;
    }
}
