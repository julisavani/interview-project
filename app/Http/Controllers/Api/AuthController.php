<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginUserRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponses;


    /**
     * Login
     * 
     * Authenticates the user and returns the user's API token.
     * 
     * @unauthenticated
     * @group Authentication
     * @response 200 {
  
     */
    public function login(LoginUserRequest $request) {
        try {
            $request->validated($request->all());

            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error('Invalid credentials', 401);
            }

            $user = User::firstWhere('email', $request->email);

            return $this->ok(
                'Authenticated',
                [
                    'token' => $user->createToken('API token for ' . $user->email)->plainTextToken
                ]
            );
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => ['message' => 'Please Try Again', 'error_message'=> $e->getMessage()]], 422);
        }
    }
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);

        
            if ($validator->fails()) {
                return response()->json(['success' => false, "error" => $validator->errors()->toArray()], 422);
            }


            $data = $request->all();
            $check =  User::create($data);
            return $this->ok('Register  successfully' , $check);
        }catch (\Exception $e) {
            return response()->json(['success' => false, 'data' => ['message' => 'Please Try Again', 'error_message'=> $e->getMessage()]], 422);
        }
    }

    /**
     * Logout
     * 
     * Signs out the user and destroy's the API token.
     * 
     * @group Authentication
     * @response 200 {}
     */
    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }
}
