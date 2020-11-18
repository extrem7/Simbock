<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Frontend\Http\Requests\Volunteer\ResumeRequest;

class ResumeController extends Controller
{
    use HasVolunteer;

    public function store(ResumeRequest $request): JsonResponse
    {
        $volunteer = $this->volunteer();

        $media = $volunteer->addMedia($request->file)->toMediaCollection('resume');
        $resume = $this->volunteer()->resume()->create([
            'title' => $request->title,
            'file_id' => $media->id
        ]);

        return response()->json([
            'message' => 'Resume has been uploaded.',
            'url' => $media->getFullUrl(),
            'created_at' => $resume->created_at
        ]);
    }

    public function destroy(): JsonResponse
    {
        $resume = $this->volunteer()->resume;
        $resume->file()->delete();
        $resume->delete();

        return response()->json(['message' => 'Resume has been deleted.']);
    }
}
