<?php

namespace Modules\Admin\Http\Controllers\Users;

use App\Models\Company;
use App\Models\Volunteers\Volunteer;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Requests\IndexRequest;

class VolunteerController extends Controller
{
    use CRUDController;

    protected string $resource = 'companies';

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Volunteers');

        $volunteers = Volunteer::select([
            'id', 'user_id', 'city_id', 'job_title', 'completeness'
        ])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->when($request->has('sortBy'), function (Builder $users) use ($request) {
                $users->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc');
            })
            ->with(['user', 'city'])
            ->paginate(10);

        $volunteers->transform(fn(Volunteer $volunteer) => $volunteer->append('name'));

        if (request()->expectsJson()) {
            return $volunteers;
        }

        share(compact('volunteers'));

        return view('admin::volunteers.index');
    }
}
