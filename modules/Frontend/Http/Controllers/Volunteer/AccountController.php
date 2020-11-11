<?php

namespace Modules\Frontend\Http\Controllers\Volunteer;

use App\Models\Jobs\Hour;
use App\Models\Jobs\Sector;
use App\Models\Jobs\Skill;
use App\Models\Jobs\Type;
use App\Models\Map\US\City;
use App\Models\Volunteers\MoreInfo\Degree;
use App\Models\Volunteers\MoreInfo\VeteranStatus;
use App\Models\Volunteers\MoreInfo\YearOfExperience;
use App\Models\Volunteers\Volunteer;
use App\Services\LocationService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Volunteer\AccountRequest;

class AccountController extends Controller
{
    public function page(LocationService $locationService)
    {
        $this->seo()->setTitle('Your volunteering account');

        $user = Auth::getUser();
        /* @var $volunteer Volunteer */
        $volunteer = $user->volunteer;
        $volunteer->append(['name']);
        if ($volunteer->avatarMedia) $volunteer->append(['avatar']);

        /* @var $city City */
        $city = $volunteer->city;
        $volunteer = $volunteer->toArray();

        if ($city) {
            $volunteer['city'] = [
                'text' => $locationService->mapCity($city),
                'value' => $city->id,
                'zips' => $city->zips
            ];
        }

        share(compact('volunteer'));

        $sectors = Sector::all('name', 'id')->map(fn(Sector $s) => ['text' => $s->name, 'value' => $s->id]);
        $types = Type::all('name', 'id')->map(fn(Type $t) => ['text' => $t->name, 'value' => $t->id]);
        $hours = Hour::all('name', 'id')->map(fn(Hour $h) => ['text' => $h->name, 'value' => $h->id]);
        $skills = Skill::all(['name', 'id'])->map(fn(Skill $s) => ['text' => $s->name]);

        $yearsOfExperience = YearOfExperience::all(['name', 'id'])
            ->map(fn(YearOfExperience $y) => ['text' => $y->name, 'value' => $y->id]);
        $degrees = Degree::all(['name', 'id'])
            ->map(fn(Degree $d) => ['text' => $d->name, 'value' => $d->id]);
        $veteranStatuses = VeteranStatus::all(['name', 'id'])
            ->map(fn(VeteranStatus $s) => ['text' => $s->name, 'value' => $s->id]);

        share(
            compact(['sectors', 'types', 'hours', 'skills', 'yearsOfExperience', 'degrees', 'veteranStatuses'])
        );

        return view('frontend::volunteer.account');
    }

    public function update(AccountRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = Auth::getUser();
        $volunteer = $user->volunteer;
        $volunteer->update($data);

        if ($name = $request->name) $user->update(compact('name'));

        return response()->json(['message' => 'Your account has been updated.']);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        ['avatar' => $avatar] = $this->validate($request, [
            'avatar' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,bmp,png']
        ]);

        /* @var $volunteer Volunteer */
        $volunteer = Auth::getUser()->volunteer;

        $volunteer->uploadAvatar($avatar);
        $volunteer->load('avatarMedia');

        return response()->json([
            'message' => 'Company logo has been uploaded.',
            'avatar' => $volunteer->avatar
        ]);
    }

    public function destroyAvatar(): JsonResponse
    {
        /* @var $volunteer Volunteer */
        $volunteer = Auth::getUser()->volunteer;
        $volunteer->deleteAvatar();
        $volunteer->load('avatarMedia');

        return response()->json(['message' => 'Your avatar has been deleted.', 'avatar' => $volunteer->avatar]);
    }
}
