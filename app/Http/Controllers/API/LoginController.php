<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Userlog;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    /**
     * Handle account login request
     *
     * @param LoginRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {

        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)):
            return response()->json([
                'success' => false,
                'error' => true,
                'errorType' => 'Authentication',
                'message' => __('login.authenticate_user'),
            ], 401);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        if (isset($credentials['email'])) {
            $user_info = User::with('role')->where('email', $credentials['email'])->first();
        } elseif (isset($credentials['username'])) {
            $user_info = User::with('role')->where('username', $credentials['username'])->first();
        }

        if (!is_null($user_info)) {

            if ($user_info->email_verified_at == null) {
                Auth::logout();
                return response()->json([
                    'success' => false,
                    'error' => true,
                    'errorType' => 'notVerified',
                    'message' => __('login.email_not_verified'),
                ], 401);
            }

            if (Hash::check($credentials['password'], $user_info->password)) {

                $isExists = Userlog::where("user_id", $user_info->id)->where("status", 1)->first();

                if (!is_null($isExists)) {
                    /*return response()->json([
                'success' => true,
                'error' => false,
                'errorType' => 'loggedin',
                'message' => __('!Hay, You are already logedin!!'),
                ]);*/
                } else {
                    $userLog = new Userlog();
                    $userLog->user_id = $user_info->id;
                    $userLog->login_date = date("Y-m-d H:i:s");
                    $userLog->status = 1;
                    $userLog->save();
                }

                // Add Token
                $token = auth()->attempt($credentials);
                $role = Role::with('permissions', 'user')->where('id', '=', $user_info->role->id)->first();
                $accessPermissions = $role->permissions;
                return $this->authenticated($token, $user_info, $accessPermissions);

            } else {
                return response()->json([
                    'success' => false,
                    'error' => true,
                    'message' => __('login.wrong_password'),
                ], 400);
            }
        } else {
            return response()->json([
                'success' => false,
                'error' => true,
                'errorType' => 'Authentication',
                'message' => __('login.authenticate_user'),
            ], 401);
        }

    }

    /**
     * Handle response after user authenticated
     *
     * @param Auth $token
     *
     * @return \Illuminate\Http\Response
     */
    protected function authenticated($token, $user_info, $accessPermissions)
    {
        // dd($user_info->role->name);
        return response()->json([
            'success' => true,
            'error' => false,
            'access_token' => $token,
            'token_type' => 'Bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60,
            'expires_in' => Carbon::now()->addMinutes(260),
            'user' => $user_info,
            'accessPermissions' => $accessPermissions,
        ]);
    }

    /**
     * Handle response after user logout
     *
     * @return Json Response
     */
    public function rolePermissionAccess($profileId)
    {

        try {
            $userType = UserType::where('ProfileId','=', $profileId)->first();
            $roleId = $userType->role_id;
            $accessPermissions = Role::with('permissions')->where('id', '=', $roleId)->first();
            return response()->json([
                'success' => true,
                'accessPermissions' => $accessPermissions,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * Handle response after user logout
     *
     * @return Json Response
     */
    public function logout(Request $request)
    {
        try {
            $authId = auth()->user()->id;
            $isUserLogEx = Userlog::where('user_id', $authId)->where('status', 1)->orderBy('id', 'DESC')->first();

            if (!is_null($isUserLogEx)) {
                Userlog::where('id', $isUserLogEx->id)->update(['logout_date' => date('Y-m-d H:i:s'), 'status' => 0]);
            }
            Auth::logout();
            // JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success' => true,
                'message' => __('login.user_logout'),
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

    /**
     * Show greetings
     *
     * @param Request $request [description]
     * @return [type] [description]
     */
    public function index(Request $request)
    {
        try {
            $data = trans('language.welcome');
            return response()->json([
                'success' => true,
                'message' => $data,
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 401);
        }
    }

}
