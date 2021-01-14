<?php

namespace Modules\Admin\Http\Controllers\Users;

use App\Models\User;
use Hash;
use Illuminate\Database\Eloquent\Builder;
use Modules\Admin\Http\Controllers\Controller;
use Modules\Admin\Http\Controllers\Traits\CRUDController;
use Modules\Admin\Http\Requests\IndexRequest;
use Modules\Admin\Http\Requests\UserRequest;
use Modules\Admin\Repositories\UserRepository;

class UserController extends Controller
{
    use CRUDController;

    protected UserRepository $userService;

    protected string $resource = 'users';

    public function __construct()
    {
        $this->userService = app(UserRepository::class);
    }

    public function index(IndexRequest $request)
    {
        $this->seo()->setTitle('Users');

        $users = User::query()->select(['id', 'email', 'name', 'created_at'])
            ->when($request->get('searchQuery'), fn($q) => $q->search($request->get('searchQuery')))
            ->when($request->has('sortBy'), function (Builder $users) use ($request) {
                $users->orderBy($request->get('sortBy'), $request->get('sortDesc') ? 'desc' : 'asc');
            })
            ->with('roles')
            ->paginate(10);

        $users->getCollection()->transform(function ($user) {
            $user['role'] = ucfirst($user->roles->implode('name', ' '));
            return $user;
        });
        if (request()->expectsJson()) {
            return $users;
        } else {
            share(compact('users'));
        }

        return view('admin::users.index');
    }

    public function create()
    {
        $this->seo()->setTitle('Create a new user');

        $this->userService->shareForCRUD();

        return $this->form();
    }

    public function store(UserRequest $request)
    {
        $this->seo()->setTitle('Edit a user');

        $password = Hash::make($request->input('password'));

        $user = User::create(array_merge($request->only('email', 'name', 'type'), compact('password')));

        $user->assignRole($request->input('role'));

        if ($user->is_volunteer) {
            $user->volunteer()->create();
        }

        return response()->json([
            'status' => 'User has been created',
            'title' => $this->seo()->getTitle(),
            'user' => $user
        ], 201);
    }

    public function edit(User $user)
    {
        $this->seo()->setTitle('Edit a user');

        $this->userService->shareForCRUD();

        $user->role = $user->roles()->first()->id ?? null;

        share(compact('user'));

        return $this->form();
    }

    public function update(UserRequest $request, User $user)
    {
        $data = $request->only('email', 'name', 'type');
        if ($password = $request->input('password')) {
            $data['password'] = Hash::make($password);
        }
        $user->update($data);

        $user->syncRoles($request->input('role'));

        return response()->json(['status' => 'User has been updated', 'user' => $user]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['status' => 'User has been deleted']);
    }
}
