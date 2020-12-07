<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Requests\Volunteer\JobRequest;

class JobController extends Controller
{
    use HasVolunteer;

    public function update(JobRequest $request): JsonResponse
    {
        $volunteer = $this->volunteer();

        $volunteer->update([
            'job_title' => $request->job_title
        ]);

        $volunteer->locations()->sync($request->locations);
        $volunteer->types()->sync($request->types);
        $volunteer->hours()->sync($request->hours);

        $sectors = $request->sectors;
        $volunteer->roles()
            ->select(['sector_id', 'role_id'])
            ->distinct()
            ->get()
            ->groupBy('sector_id')
            ->keys()
            ->each(function (int $sector) use ($volunteer, $sectors) {
                if (!array_key_exists($sector, $sectors)) {
                    $volunteer->roles()->where('sector_id', $sector)->detach();
                }
            });

        foreach ($sectors as $sector) {
            $roles = [];
            foreach ($sector['roles'] as $role) {
                $roles[$role] = ['sector_id' => $sector['id']];
            }
            $volunteer->roles()->wherePivot('sector_id', $sector['id'])->sync($roles);
        }

        $this->volunteer()->calculateCompleteness();

        return response()->json([
            'message' => 'Desired job has been saved.',
        ]);
    }

    public function destroy(): JsonResponse
    {
        $volunteer = $this->volunteer();

        $volunteer->update(['job_title' => null]);
        $volunteer->locations()->detach();
        $volunteer->types()->detach();
        $volunteer->hours()->detach();
        $volunteer->roles()->detach();

        $this->volunteer()->calculateCompleteness();

        return response()->json(['message' => 'Desired job has been deleted.']);
    }
}
