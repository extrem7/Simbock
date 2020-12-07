<?php

namespace Modules\Frontend\Http\Controllers\Company;

use App\Models\Company;
use Auth;

trait HasCompany
{
    protected ?Company $company = null;

    protected function company(): Company
    {
        if (!$this->company) {
            $this->company = Auth::user()->company;
        }

        return $this->company;
    }
}
