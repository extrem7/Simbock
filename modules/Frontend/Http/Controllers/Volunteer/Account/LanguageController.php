<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Requests\Volunteer\LanguageRequest;

class LanguageController extends Controller
{
    use HasVolunteer;

    public function store(LanguageRequest $request): JsonResponse
    {
        $this->volunteer()->languages()->attach($request->language_id, [
            'fluency' => $request->fluency
        ]);
        return response()->json(['message' => 'Language has been added.']);
    }

    public function update(LanguageRequest $request, Language $language): JsonResponse
    {
        //$certificate->update($request->validated());
        return response()->json(['message' => 'Language has been updated.']);
    }

    public function destroy(Language $language): JsonResponse
    {
        $this->volunteer()->languages()->detach($language->id);
        return response()->json(['message' => 'Language has been deleted.']);
    }
}
