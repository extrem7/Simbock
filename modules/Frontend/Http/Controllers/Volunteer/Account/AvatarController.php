<?php

namespace Modules\Frontend\Http\Controllers\Volunteer\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AvatarController extends Controller
{
    use HasVolunteer;

    public function update(Request $request): JsonResponse
    {
        ['avatar' => $avatar] = $this->validate($request, [
            'avatar' => ['required', 'image', 'max:2048', 'mimes:jpg,jpeg,bmp,png']
        ]);

        $volunteer = $this->volunteer();

        $volunteer->uploadAvatar($avatar);
        $volunteer->load('avatarMedia');

        return response()->json([
            'message' => 'Company logo has been uploaded.',
            'avatar' => $volunteer->avatar
        ]);
    }

    public function destroy(): JsonResponse
    {
        $volunteer = $this->volunteer();
        $volunteer->deleteAvatar();
        $volunteer->load('avatarMedia');

        return response()->json(['message' => 'Your avatar has been deleted.', 'avatar' => $volunteer->avatar]);
    }
}
