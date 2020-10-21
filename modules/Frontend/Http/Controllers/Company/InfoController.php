<?php

namespace Modules\Frontend\Http\Controllers\Company;

use App\Models\Jobs\Sector;
use App\Models\Jobs\Size;
use App\Services\LocationService;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Requests\Company\InfoRequest;

class InfoController extends Controller
{
    public function showForm(LocationService $locationService)
    {
        $this->seo()->setTitle('Company Info');

        $user = \Auth::getUser();
        if ($company = $user->company) {
            if ($company->logoMedia) $company->append('logo');

            $city = $company->city;
            $company = $company->toArray();

            $company['city'] = [
                'text' => $locationService->mapCity($city),
                'value' => $city->id,
                'zips' => $city->zips
            ];

            share(compact('company'));
        }

        $sectors = Sector::all('name', 'id')->map(fn(Sector $s) => ['text' => $s->name, 'value' => $s->id]);
        $sizes = Size::all('name', 'id')->map(fn(Size $s) => ['text' => $s->name, 'value' => $s->id]);

        share(compact('user', 'sectors', 'sizes'));

        return view('frontend::company.info');
    }

    public function update(InfoRequest $request)
    {
        $data = $request->only([
            'name', 'title', 'sector_id', 'description', 'size_id',
            'address', 'address_2', 'city_id', 'zip',
            'phone', 'email', 'social'
        ]);

        $user = \Auth::getUser();
        if ($company = $user->company) {
            $company->update($data);
        } else {
            $user->company()->create($data);
        }

        if ($name = $request->user_name) $user->update(compact('name'));

        return response()->json(['message' => 'Company info has been updated.']);
    }

    public function uploadLogo(Request $request)
    {
        ['logo' => $logo] = $this->validate($request, [
            'logo' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,bmp,png']
        ]);

        $company = \Auth::getUser()->company;

        $company->uploadLogo($logo);
        $company->load('logoMedia');

        return response()->json([
            'message' => 'Company logo has been uploaded.',
            'logo' => $company->logo
        ]);
    }

    public function destroyLogo()
    {
        $company = \Auth::getUser()->company;
        $company->deleteLogo();

        return response()->json(['message' => 'Company logo has been deleted.',]);
    }
}
