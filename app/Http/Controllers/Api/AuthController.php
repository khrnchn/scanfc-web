<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use PasswordValidationRules;
    
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

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => function ($attribute, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('Your current password doesnt match.');
                }
            },
            'password' => $this->passwordRules(),
        ]);

        if ($validator->fails()) {
            return $this->return_api(false, Response::HTTP_UNPROCESSABLE_ENTITY, 'Failed to change your password.', null, $validator->errors());
        }

        Auth::user()->fill([
            'password' => Hash::make($request->password)
        ])->save();
        
        return $this->return_api(true, Response::HTTP_OK, 'Successfully changed your password.', null, null);
    }
}
