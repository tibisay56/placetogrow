<?php

namespace App\Actions\Sites;

use App\Models\Site;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function execute(Site $site): void
    {
        if ($site->avatar) {
            Storage::disk('public')->delete($site->avatar);
        }
        $site->delete();
    }
}
