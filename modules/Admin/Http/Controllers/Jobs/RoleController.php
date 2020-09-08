<?php

namespace Modules\Admin\Http\Controllers\Jobs;

use App\Models\Jobs\Role;
use App\Models\Jobs\Sector;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Controllers\Traits\SortableController;
use Modules\Admin\Http\Requests\Jobs\RoleRequest;
use Modules\Admin\Repositories\Jobs\RoleRepository;

class RoleController extends Controller
{
    use SortableController;
    use CRUDController;

    protected string $modelClass = Role::class;
    protected string $resource = 'roles';

    protected RoleRepository $repository;

    public function __construct()
    {
        $this->repository = app(RoleRepository::class);
    }

    public function index(Sector $sector = null)
    {
        if ($sector) {
            $this->seo()->setTitle("Roles of $sector->name sector");
            $roles = $sector->roles()->ordered()->get(['id', 'name']);
        } else {
            $this->seo()->setTitle('Roles');
            $roles = Role::ordered()->get(['id', 'name']);
        }

        share(compact('roles'));

        return view('admin::crud.index', ['resource' => 'roles']);
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new role');
        $this->repository->shareForCRUD();
        return $this->form();
    }

    public function store(RoleRequest $request)
    {
        $this->seo()->setTitle('Edit a role');

        $role = Role::create($request->only('name'));
        $request->syncSectors($role);

        return response()->json([
            'status' => 'Role has been created',
            'title' => $this->seo()->getTitle(),
            'role' => $role
        ], 201);
    }

    public function edit(Role $role)
    {
        $this->seo()->setTitle('Edit a role');

        $this->repository->shareForCRUD();

        $role->load('sectors');
        $role->sectors->transform(fn(Sector $s) => $s->id);
        share(compact('role'));

        return $this->form();
    }

    public function update(roleRequest $request, Role $role)
    {
        $role->update($request->validated());
        $request->syncSectors($role);

        return response()->json(['status' => 'Role has been updated', 'role' => $role]);
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['status' => 'Role has been deleted']);
    }
}
