<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\SearchQuery;
use App\Models\Volunteers\Surveys\Survey;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Requests\IndexRequest;

class SurveyController extends Controller
{
    use CRUDController;

    protected string $resource = 'surveys';

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Surveys');

        $surveys = Survey::with(['volunteer', 'source'])
            ->when($request->has('sortBy'), function (Builder $users) use ($request) {
                $users->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc');
            })
            ->latest()
            ->paginate(10);

        $surveys->transform(function (Survey $survey) {
            $survey->volunteer->append('name');
            return $survey;
        });

        if (request()->expectsJson()) {
            return $surveys;
        }

        share(compact('surveys'));

        return $this->listing();
    }
}
