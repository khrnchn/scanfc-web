<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        // validate email and password
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // return errors if validation failed
        if ($validator->fails()) {
            return $this->return_api(false, Response::HTTP_UNPROCESSABLE_ENTITY, null, null, $validator->errors());
        }

        // if login successfull
        if (Auth::attempt($validator->validated(), true)) {
            // get user using auth
            $user = Auth::user();
            $userTemp = new User();
            $userTemp->email = $user->email;

            $user->accessToken = $user->createToken('auth-token')->plainTextToken;

            // return response with user resource model
            return $this->return_api(true, Response::HTTP_OK, null, new UserResource($user), null);
        }
        return $this->return_api(false, Response::HTTP_UNAUTHORIZED, "Failed to authorize.", null, null);
    }

    public function logout()
    {
        // revoke all tokens
        $user = Auth::user()->tokens()->delete();

        return $this->return_api(true, Response::HTTP_OK, null, null, null);
    }

    public function me()
    {
        $user = Auth::user();
        if ($user != null) {
            return $this->return_api(true, Response::HTTP_OK, null, new UserResource($user), null);
        } else {
            return $this->return_api(false, Response::HTTP_UNAUTHORIZED, null, null, null);
        }
    }
}
