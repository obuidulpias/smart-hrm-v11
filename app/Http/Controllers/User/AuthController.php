<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth, Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    /**
     * Signup Here
     * 
     */
    public function signup(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => ['required', 'string', 'min:6'],
            'confirm_password' => ['required', 'string', 'min:6']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => 'vaidation error found.',
                'errors' => $validator->errors()->all()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            //Password and Confirm Password check here
            if (trim($request->password) != trim($request->confirm_password)) {
                return response()->json(['status' => 'failed', 'message' => 'Password does not match.'], 401);
            }
            //dd($request->confirm_password);
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $user->createToken('User Token')->accessToken;

            DB::commit();
            $user = array(
                [
                    'name' => $request->name,
                    'email' => $request->email
                ]
            );
            return response(['status' => 'success', 'message' => 'User created successfully.', 'data' => $user, 'token' => $token], 200);
        } catch (\Exception $e) {
            $this->response = errorResponse($e);
        }

        //return $this->response;
    }
    /**
     * Summary of login
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('User Token')->accessToken;
            //dd($token);
            return response(['status' => 'success', 'token' => $token], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'User info are not correct. Please try valid info.'
            ], 401);
        }


    }
    /**
     * Summary of logout
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $accessToken = Auth::guard('api')->user()->token();
        $accessToken->revoke();
        return response()->json(['status' => 'success', 'message' => 'Successfully logged out']);
        /*
        if (Auth::guard('api')->check()) {
            $accessToken = Auth::guard('api')->user()->token();

            // \DB::table('oauth_refresh_tokens')
            //     ->where('access_token_id', $accessToken)
            //     ->update(['revoked' => true]);
            $accessToken->revoke();
            return response()->json(['status' => 'success', 'message' => 'Successfully logged out']);
        }
        return response(['status' => 'failed', 'message' => 'Unauthorized'], 401);
        */
    }
    /**
     * Summary of userDetails
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function userDetails()
    {
        $user = Auth::guard('api')->user();
        return response(['status' => 'success', 'data' => $user], 200);
        /*
        if (Auth::guard('api')->check()) {
            //$user = Auth::guard('api')->user();
            $user = User::all();
            return response(['status' => 'success', 'data' => $user], 200);
        } else {
            return response(['status' => 'failed', 'message' => 'Unauthorized'], 401);
        }
        */

    }
}
