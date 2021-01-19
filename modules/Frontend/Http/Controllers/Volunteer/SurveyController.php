<?php

namespace Modules\Frontend\Http\Controllers\Volunteer;

use App\Models\Volunteers\Surveys\Source;
use App\Models\Volunteers\Surveys\Survey;
use DB;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Controllers\Controller;
use Modules\Frontend\Http\Controllers\Volunteer\Account\HasVolunteer;
use Modules\Frontend\Http\Requests\Volunteer\Survey\CompleteRequest;
use Modules\Frontend\Http\Requests\Volunteer\Survey\InitialRequest;
use Modules\Frontend\Http\Requests\Volunteer\Survey\UpdateJobRequest;

class SurveyController extends Controller
{
    use HasVolunteer;

    public function page()
    {
        $this->seo()->setTitle('Short Survey');

        $sources = Source::all();

        share(compact('sources'));

        return view('frontend::volunteer.survey');
    }

    public function store(InitialRequest $request): JsonResponse
    {
        /* @var $survey Survey */
        $survey = $this->volunteer()->surveys()->create([
            'source_id' => $request->source_id,
            'specified' => $request->specified
        ]);

        return response()->json(['message' => 'Ok.']);
    }

    public function updateJob(UpdateJobRequest $request): JsonResponse
    {
        $this->volunteer()->workExperiences()->create([
            'title' => $request->job_title,
            'company' => $request->company_name,
            'start' => DB::raw('NOW()')
        ]);

        return response()->json(['message' => 'You profile has been updated.']);
    }

    public function complete(CompleteRequest $request): JsonResponse
    {
        $survey = $this->volunteer()->surveys()->latest()->first();
        if ($survey) {
            $survey->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'phone' => $request->phone,
                'company_name' => $request->company_name,
                'description' => $request->description
            ]);
        }

        return response()->json(['message' => 'Thanks you for your apply!']);
    }
}
