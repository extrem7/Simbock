<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use App\Models\Volunteers\Education;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Requests\Volunteer\EducationRequest;

class EducationController extends Controller
{
    use HasVolunteer;

    public function store(EducationRequest $request): JsonResponse
    {
        $education = $this->volunteer()->educations()->create($request->validated());
        return response()->json(['message' => 'Education has been added.', 'id' => $education->id]);
    }

    public function update(EducationRequest $request, Education $education): JsonResponse
    {
        $education->update($request->validated());
        return response()->json(['message' => 'Education has been updated.', 'id' => $education->id]);
    }

    public function destroy(Education $education): JsonResponse
    {
        $education->delete();
        return response()->json(['message' => 'Education has been deleted.']);
    }
}
