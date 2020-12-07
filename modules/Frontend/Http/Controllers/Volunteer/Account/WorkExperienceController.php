<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use App\Models\Volunteers\WorkExperience;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Requests\Volunteer\WorkExperienceRequest;

class WorkExperienceController extends Controller
{
    use HasVolunteer;

    public function store(WorkExperienceRequest $request): JsonResponse
    {
        $workExperience = $this->volunteer()->workExperiences()->create($request->validated());
        $this->volunteer()->calculateCompleteness();
        return response()->json(['message' => 'Work experience has been added.', 'id' => $workExperience->id]);
    }

    public function update(WorkExperienceRequest $request, WorkExperience $workExperience): JsonResponse
    {
        $workExperience->update($request->validated());
        $this->volunteer()->calculateCompleteness();
        return response()->json(['message' => 'Work experience has been updated.', 'id' => $workExperience->id]);
    }

    public function destroy(WorkExperience $workExperience): JsonResponse
    {
        $workExperience->delete();
        $this->volunteer()->calculateCompleteness();
        return response()->json(['message' => 'Work experience has been deleted.']);
    }
}
