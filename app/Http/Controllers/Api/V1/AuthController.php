<?php

namespace App\Http\Controllers\Api\V1;

use App\Cores\ApiResponse;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\Api\V1\LoginResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * @OA\Post(
     *      path="/api/v1/auth/login",
     *      summary="Sign in",
     *      description="Login by email, password",
     *      tags={"Auth"},
     *
     *      @OA\RequestBody(
     *          required=true,
     *          description="Pass user credentials",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="email", type="email", example="super@inosoft.com"),
     *              @OA\Property(property="password", type="string", format="password", example="password123"),
     *          ),
     *      ),
     *
     *      @OA\Response(
     *          response=422,
     *          description="Wrong credentials response",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="The given data was invalid."),
     *              @OA\Property(property="errors", type="object", example={}),
     *          )
     *      )
     * )
     */
    public function login(User $user, LoginRequest $request)
    {
        $user = $user->firstWhere('email', $request->email);

        if (! $user) {
            return $this->responseJson('error', 'Unauthorized. Email not found', '', 401);
        }

        if (! Auth::attempt($request->validated())) {
            return $this->responseJson('error', 'Unauthorized.', '', 401);
        }

        $data = new LoginResource($user);

        return $this->responseJson('success', 'Login success', $data);
    }

    /**
     * @OA\Post(
     *       path="/api/v1/auth/logout",
     *       summary="Log user out ",
     *       description="Endpoint to log current user out",
     *       tags={"Auth"},
     *       security={
     *           {"token": {}}
     *       },
     *
     *       @OA\Response(
     *           response=200,
     *           description="OK"
     *       ),
     *       @OA\Response(
     *           response=401,
     *           description="Unauthorized"
     *       ),
     * )
     */
    public function logout()
    {
        $user = auth()->user();
        if (! $user) {
            return $this->responseJson('error', __('Unauthorized.'), '', 401);
        }
        // FIXME : Fixing Revoke the token that was used to authenticate the current request
        // $revoke = auth()->user()->currentAccessToken()->delete();

        /** Use below code if you want to log current user out in all devices */
        $revoke = $user->tokens()->delete();
        if (! $revoke) {
            return $this->responseJson('error', __('Logout failed'), '', 400);
        }

        return $this->responseJson('success', __('Logout successfully'));
    }
}
