<?php

namespace App\Actions\Sites;

use App\Actions\Action;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class StoreAction extends Action
{
    public function execute(array $data): Site
    {
        if (isset($data['avatar'])) {
            $file = $data['avatar'];
            $path = $file->store('avatars', ['disk' => 'public']);
            $data['avatar'] = $path;
        }

        $data['user_id'] = Auth::id();

        return Site::create($data);
    }
}
