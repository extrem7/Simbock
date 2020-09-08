<?php

namespace Modules\Admin\Http\Controllers\Jobs;

use App\Models\Jobs\Sector;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Controllers\Traits\SortableController;
use Modules\Admin\Http\Requests\Jobs\SectorRequest;

class SectorController extends Controller
{
    use SortableController;
    use CRUDController;

    protected string $modelClass = Sector::class;
    protected string $resource = 'sectors';

    public function index()
    {
        $this->seo()->setTitle('Sectors');

        $sectors = Sector::ordered()->withCount('roles')->get(['id', 'name']);

        share(compact('sectors'));

        return $this->listing();
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new sector');

        return $this->form();
    }

    public function store(SectorRequest $request)
    {
        $this->seo()->setTitle('Edit a sector');

        $sector = new Sector($request->validated());
        $sector->save();

        return response()->json([
            'status' => 'Sector has been created',
            'title' => $this->seo()->getTitle(),
            'sector' => $sector
        ], 201);
    }

    public function edit(Sector $sector)
    {
        $this->seo()->setTitle('Edit a sector');

        share(compact('sector'));

        return $this->form();
    }

    public function update(SectorRequest $request, Sector $sector)
    {
        $sector->update($request->validated());

        return response()->json(['status' => 'Sector has been updated', 'sector' => $sector]);
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();
        return response()->json(['status' => 'Sector has been deleted']);
    }
}
