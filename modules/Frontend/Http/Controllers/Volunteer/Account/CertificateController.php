<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use App\Models\Volunteers\Certificate;
use Illuminate\Http\JsonResponse;
use Modules\Frontend\Http\Requests\Volunteer\CertificateRequest;

class CertificateController extends Controller
{
    use HasVolunteer;

    public function store(CertificateRequest $request): JsonResponse
    {
        $education = $this->volunteer()->certificates()->create($request->validated());
        return response()->json(['message' => 'Certificate has been added.', 'id' => $education->id]);
    }

    public function update(CertificateRequest $request, Certificate $certificate): JsonResponse
    {
        $certificate->update($request->validated());
        return response()->json(['message' => 'Certificate has been updated.', 'id' => $certificate->id]);
    }

    public function destroy(Certificate $certificate): JsonResponse
    {
        $certificate->delete();
        return response()->json(['message' => 'Certificate has been deleted.']);
    }
}
