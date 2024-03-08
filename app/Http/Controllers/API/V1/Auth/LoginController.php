<?php

namespace App\Http\Controllers\API\V1\Auth;

use App\Data\Constants;
use App\Data\StatusCode;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\TokenService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    /**
     * Handle a login request to the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $t_key = '';
        $response = [];
        $isSwitched = false;
        $response['email_exist'] = false;


        try {
            $request->validate([
                'email' => 'required|email|max:255',
            ]);

            $user = User::where('email', $request->email)->first();

            $roles = $user ? $user->roles : null;

            if (!$user) {

                if($request->has('email') && $request->missing('password')){
                    return response()->json($response, Constants::HTTP_OK); // Return Email doesn't exist Response for PWA
                }else{
                    throw new \Exception('This email does not exist');
                }
                
            }else{
                $response['email_exist'] = true;

                $response['has_password'] = $user->has_password;

                if($request->has('email') && $request->missing('password')){ 

                    

                    return response()->json($response, Constants::HTTP_OK);
                }
            }

            if ($roles->count() < 1) {
                throw new \Exception('Sorry, you are not allowed to access.');
            }

            // if (!$user->verified) {
            //     throw new \Exception('You account is not verified yet.');
            // }

            if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {

                $user = Auth::user();
                $userService = new UserService();
                $tokenService = new TokenService();

                $response['data']['user'] = $userService->getUserInformation($user, $isSwitched);

                $response['data']['access_token'] = $tokenService->createUserAccessToken($user);
                
                return response()->json($response, Constants::HTTP_OK);

            } else {
                $response['status'] = 'error';
                $t_key = 'login_validation_message_credential_is_not_correct';
                throw new \Exception('Your credential does not correct.');
            }


        } catch (\Exception $e) {
            if ($e instanceof ValidationException) {
                $response['status'] = 'error';
                $response['message'] = $e->validator->errors()->first();
                return response()->json($response, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
            }

            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
            $response['t_key'] = $t_key;
            return response()->json($response, StatusCode::HTTP_UNPROCESSABLE_ENTITY);
        }

    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $response = [];

        $response['status'] = 'success';
        $response['message'] = 'Successfully log out';

        $tokenService = new TokenService();
        $tokenService->deleteUserAccessToken(Auth::user());

        return $response;
    }
}
