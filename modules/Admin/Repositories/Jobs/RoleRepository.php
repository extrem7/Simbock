<?php

namespace Modules\Admin\Repositories\Jobs;

use App\Models\Jobs\Sector;

class RoleRepository
{
    public function shareForCRUD()
    {
        $sectors = Sector::ordered()->get(['name', 'id'])->values();
        share(compact('sectors'));
    }
}
