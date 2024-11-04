<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use App\Model\user\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Session;
use DB;

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
    protected $redirectTo = 'member/mem';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function username()
    {
        return 'membership_no';
    }
     
    public function showLoginForm()
    {
        if (Auth::guard('admin')->check()) {
            return "<script>alert('กรุณา ออกจากระบบของ Admin ก่อน..!!'); location.replace('/index');</script>";
            exit;

        }

        if ($redirect = Session::get('url.intended')) {
            Session::forget('url.intended');
        }

        return view('member.auth.login');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            
            
            $IP = f_get_ip();
            $today = date('Y-m-d H:i:s');
            $date = explode(' ',$today);
            $session_id = Session::getId();
            // dd(Auth::user()->membership_no,$IP,$date[0],$date[1],Session::getId());

            $insert_counter_member = DB::table('www_counter_member')
                                      ->insert(
                                          [
                                              'ip_address' => $IP
                                            , 'visit_date' => $date[0]
                                            , 'visit_time' => $date[1]
                                            , 'session_id' => $session_id
                                            , 'membership_no' => Auth::user()->membership_no
                                          ]
                                        );

            return $this->sendLoginResponse($request);
        }
        
        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'mem_password' => 'required|string',
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return [
            $this->username() => $request->get('membership_no'),
            'password' => $request->get('mem_password')
        ];
    }

    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }
    protected function guard()
    {
        return Auth::guard('web');
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
        
        $this->guard('web')->logout();
        //$request->session()->invalidate();
        session()->forget('membership_no');

        if(!Auth::guard('admin')->check()){
            $request->session()->flush();
        }
        // $request->session()->flush();
        //$request->forget('url.intended');
        //$request->session()->regenerate();
        return redirect()->guest(url('index'));
    }

}
