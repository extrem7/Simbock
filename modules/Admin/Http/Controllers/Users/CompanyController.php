<?php

namespace Modules\Admin\Http\Controllers\Users;

use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Requests\IndexRequest;

class CompanyController extends Controller
{
    use CRUDController;

    protected string $resource = 'companies';

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Companies');

        $companies = Company::select([
            'id', 'user_id', 'name', 'city_id', 'stripe_id', 'card_brand', 'card_last_four'
        ])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->when($request->has('sortBy'), function (Builder $users) use ($request) {
                $users->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc');
            })
            ->with(['user', 'city'])
            ->withCount('vacancies')
            ->paginate(10);

        $companies->transform(function (Company $company) {
            $company->plan = $company->subscribed() ? $company->getPlan() : null;
            return $company;
        });

        if (request()->expectsJson()) {
            return $companies;
        }

        share(compact('companies'));

        return view('admin::companies.index');
    }
}
