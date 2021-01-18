<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\SearchQuery;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Requests\IndexRequest;

class SearchQueryController extends Controller
{
    use CRUDController;

    protected string $resource = 'search-queries';

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Search queries');

        $searchQueries = SearchQuery::with(['company', 'volunteer'])
            ->when($request->has('sortBy'), function (Builder $users) use ($request) {
                $users->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc');
            })
            ->paginate(10);

        $searchQueries->transform(function (SearchQuery $query) {
            if ($query->volunteer) {
                $query->volunteer->append('name');
            }
            return $query;
        });

        if (request()->expectsJson()) {
            return $searchQueries;
        }

        share(compact('searchQueries'));

        return $this->listing();
    }
}
