<?php

namespace App\Actions\Sites;

use App\Models\Site;
use Illuminate\Support\Facades\Storage;

class UpdateAction
{
    public function execute(Site $site, array $data): Site
    {
        if (isset($data['avatar'])) {
            $file = $data['avatar'];
            $path = $file->store('avatars', ['disk' => 'public']);
            $data['avatar'] = $path;

            if ($site->avatar) {
                Storage::disk('public')->delete($site->avatar);
            }
        }

        $site->update($data);

        return $site;
    }
}
