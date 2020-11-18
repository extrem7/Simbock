<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Models\Volunteers\Volunteer;
use Auth;

trait HasVolunteer
{
    protected ?Volunteer $volunteer = null;

    protected function volunteer(): Volunteer
    {
        if (!$this->volunteer) {
            $this->volunteer = Auth::getUser()->volunteer;
        }

        return $this->volunteer;
    }
}
