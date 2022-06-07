<?php

namespace App\Http\Controllers\Auth;

use App\Http\Contract\UserBusiness;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersTeam;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use UserBusiness;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except('logout');
    }

    public function verifyLogin()
    {
        return view('auth.verifyLogin');
    }

    public function postVerifyLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withInput();
        }

        $code = $this->randVerifyLoginCode();

        $data = [
            'to_email' => $request->email
        ];

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->login_code = $code;
            $user->save();
        }

        // Mail::send(
        //         'auth.verify_login.mail',
        //         ['code' => $code],
        //         function($message) use ($data) {
        //             $message->to($data['to_email'])
        //                     ->subject('Mã code đăng nhập');
        //         }
        //     );
        
        $toEmail = $request->email;
        session()->flash('toEmail', $toEmail);
        return redirect('/login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);
       
        $user = User::where('email', $request->email)->first();
        if (!$user) return redirect('/');
        // if ($user->login_code != trim($request->code)) {
        //     session()->flash('my_error', 'Mã đăng nhập không hợp lệ');
        //     return redirect('/verify-login');
        // }

        $teamIdsOfUser = UsersTeam::where('user_id', $user->id)->groupBy('team_id')->pluck('team_id');
        if (count($teamIdsOfUser) <= 0 || !in_array($request->team_id, $teamIdsOfUser->toArray())) {
            // $error = \Illuminate\Validation\ValidationException::withMessages([
            //     'team_id' => [__('messages.you_are_not_belong_to_the_team')],
            // ]);
            // throw $error;
            session()->flash('my_error', __('messages.you_are_not_belong_to_the_team'));
            return redirect('/verify-login');
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            session()->put('team_id', $request->team_id);
            $user->login_code = $this->randVerifyLoginCode();
            $user->save();
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'team_id' => 'required',
            'code' => 'required'
        ]);
    }

    public function signPdf(Request $request)
    {
        return view('auth.signPdf');
    }
}
