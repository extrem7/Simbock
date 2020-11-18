<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use Auth;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Volunteer\AccountRequest;
use Modules\Frontend\Repositories\VolunteerRepository;

class AccountController extends Controller
{
    use HasVolunteer;

    protected VolunteerRepository $repository;

    public function __construct()
    {
        $this->repository = app(VolunteerRepository::class);
    }

    public function page()
    {
        $this->seo()->setTitle('Your volunteering account');

        $volunteer = $this->volunteer();
        $volunteer = $this->repository->setupRelations($volunteer);
        $volunteer = $this->repository->setupAppends($volunteer);
        $this->repository->shareVolunteer($volunteer);

        $this->repository->shareForView();
        $this->repository->shareForEdit();

        return view('frontend::volunteer.account');
    }

    public function update(AccountRequest $request): JsonResponse
    {
        $user = Auth::getUser();
        $volunteer = $user->volunteer;
        $volunteer->update($request->validated());

        $request->syncSkills($volunteer);

        if ($name = $request->name) {
            $user->update(compact('name'));
        }

        return response()->json(['message' => 'Your account has been updated.']);
    }
}
