<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
// use App\Model\admin\admin;
use Illuminate\Http\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Illuminate\Validation\ValidationException;;
use Jenssegers\Agent\Agent;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/control';

    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 5; // Default is 1
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return "<script>alert('กรุณา ออกจากระบบของ Member ก่อน..!!'); location.replace('/index');</script>";
            exit;
        }

        if ($redirect = Session::get('url.intended')) {
            Session::forget('url.intended');
        }

        return view('admin.login');
    }

    // public function login(Request $request)
    // {
    //     // dd($request);
    //     $this->validateLogin($request);

    //     if ($this->attemptLogin($request)) {
    //         return $this->sendLoginResponse($request);
    //     }

    //     return $this->sendFailedLoginResponse($request);
    // }
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        $IP = f_get_ip();
        $today = date('Y-m-d H:i:s');
        $session_id = Session::getId();
        $agent = new Agent();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_ver = $agent->version($browser);
        $platform_ver = $agent->version($platform);
        $client_name  = $device . " " . $browser . " " . $browser_ver . " on " . $platform . " " . $platform_ver;

        DB::table('www_logon_detail')
            ->insert(
                [
                    'identify' => $this->guard()->user()->username,
                    'access_date' => $today,
                    'ip_address' => $IP,
                    'session_id' => $session_id,
                    'client_name' => $client_name
                ]
            );

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect()->intended($this->redirectPath());
    }

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // dd($request->session());
        $this->guard()->logout();
        //$request->session()->invalidate();
        session()->forget('membership_no');
        $request->session()->flush();
        // $request->session()->regenerate();
        return redirect()->guest(url('logon'));
    }
}
