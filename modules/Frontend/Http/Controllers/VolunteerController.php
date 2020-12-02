<?php

namespace Modules\Frontend\Http\Controllers;

use App\Models\Company;
use App\Models\Vacancy;
use App\Models\Volunteers\Volunteer;
use Auth;
use Modules\Frontend\Repositories\VolunteerRepository;

class VolunteerController extends Controller
{
    protected VolunteerRepository $repository;

    public function __construct()
    {
        $this->repository = app(VolunteerRepository::class);
    }

    public function self()
    {
        return $this->show(Auth::getUser()->volunteer);
    }

    public function show(Volunteer $volunteer)
    {
        $this->seo()->setTitle("$volunteer->name | Volunteers");

        $volunteer = $this->repository->setupRelations($volunteer);
        $volunteer = $this->repository->setupAppends($volunteer);

        $this->repository->shareVolunteer($volunteer);
        $this->repository->shareForView();

        return view('frontend::volunteers.show');
    }
}
