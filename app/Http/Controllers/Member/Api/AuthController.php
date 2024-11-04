<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\member\api\Member as User;
use App\Model\member\SmMemMembershipRegistered;
use App\Model\member\www_memregis_logs;
use Illuminate\Auth\Notifications\ResetPassword;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\ValidationException;
// use Illuminate\Http\Exceptions\HttpResponseException;
// use Illuminate\Http\JsonResponse;
use ReCaptcha\ReCaptcha;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jenssegers\Agent\Agent;

class AuthController extends Controller
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

    // use AuthenticatesUsers;
    use AuthRegisterTrait;
    use ThrottlesLogins;


    protected $maxAttempts = 3; // Default is 5
    protected $decayMinutes = 5; // Default is 1

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'forget', 'registerMobile', 'forgetMobile']]);
    }


    public function registerMobile(Request $request)
    {
        $req = $request->json()->all();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|unique:sc_confirm_register|max:6',
            'id_card' => 'required|exists:sm_mem_m_membership_registered',
            'date_of_birth' => 'required|exists:sm_mem_m_membership_registered',
        ];

        $validator = Validator::make($req, $rules, $this->messages());

        if ($validator->passes()) {
            //TODO Handle your data
            $envsecret = config('auth.SECRET_AUTH');

            $date = date('Y-m-d H:i:s');

            $user = User::create([
                'membership_no' => $req['membership_no'],
                'mem_email' =>  null,
                'phone_no' => null,
                'mem_password' => SoatEncode($req['password']),
                'mem_password_sha' => hash_hmac('sha256', $req['password'], $envsecret),
                'mem_confirm' => 1,
                'operate_date' => $date,
            ]);

            if ($user) {
                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'ลงทะเบียนสำเร็จ'
                ]);
            }
        } else {
            //TODO Handle your error
            $errors = $validator->errors()->all();
            return response()->json(compact('errors'));
        }

        // $token = $this->guard()->login($user);

        // return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $req = $request->json()->all();
        $membershipNo = $request->input('membership_no');
        $resetPassStatus = DB::table('sc_confirm_register')
                                ->where('membership_no', $membershipNo)
                                ->pluck('password_reset_status')
                                ->first();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|unique:sc_confirm_register|max:6',
            'id_card' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'member_name' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no'])
            ],
            'member_surname' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'date_of_birth' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ]
        ];

        $validator = Validator::make($req, $rules, $this->messages());

        if ($validator->passes()) {
            //TODO Handle your data
            $envsecret = config('auth.SECRET_AUTH');

            $date = date('Y-m-d H:i:s');

            $user = User::create([
                'membership_no' => $req['membership_no'],
                'mem_email' =>  null,
                'phone_no' => null,
                'mem_password' => SoatEncode($req['password']),
                'mem_password_sha' => hash_hmac('sha256', $req['password'], $envsecret),
                'mem_password_encrypt' => SoatEncode($req['password']),
                'mem_confirm' => 1,
                'operate_date' => $date,
            ]);

            if ($resetPassStatus == 0 && $resetPassStatus != null) {
                DB::table('sc_confirm_register')
                    ->where('membership_no', $membershipNo)
                    ->update(['password_reset_status' => 2]);
            }

            if ($user) {
                $arrayinsert = [
                    "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => "",
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'register', $req['membership_no'], 'web');
                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'ลงทะเบียนสำเร็จ'
                ]);
            }
        } else {
            //TODO Handle your error
            $errors = $validator->errors()->all();
            $arrayinsert = [
                "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                "error_response" => $errors[0]
            ];
            // Add www_memregis_logs Mobile
            $this->SaveMemberregis_logs($request, $arrayinsert, 'register_error', $req['membership_no'], 'mobiles');
            return response()->json(compact('errors'));
        }

        // $token = $this->guard()->login($user);

        // return $this->respondWithToken($token);
    }

    public function forgetMobile(Request $request)
    {
        $req = $request->json()->all();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered|exists:sc_confirm_register,membership_no,mem_confirm,1|max:6',
            'id_card' => 'required|exists:sm_mem_m_membership_registered',
            'date_of_birth' => 'required|exists:sm_mem_m_membership_registered',
        ];

        $validator = Validator::make($req, $rules, $this->messages());

        if ($validator->passes()) {
            //TODO Handle your data
            $envsecret = config('auth.SECRET_AUTH');

            $date = date('Y-m-d H:i:s');

            $user = User::where('membership_no', $req['membership_no'])
                ->update(array(
                    'mem_password' => SoatEncode($req['password']),
                    'mem_password_sha' => hash_hmac('sha256', $req['password'], $envsecret)
                ));

            if ($user) {
                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'เปลี่ยนรหัสผ่านสำเร็จ'
                ]);
            }
        } else {
            //TODO Handle your error
            $errors = $validator->errors()->all();
            return response()->json(compact('errors'));
        }
    }

    public function forget(Request $request)
    {
        $req = $request->json()->all();
        $membershipNo = $request->input('membership_no');
        $resetPassStatus = DB::table('sc_confirm_register')
                                ->where('membership_no', $membershipNo)
                                ->pluck('password_reset_status')
                                ->first();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered|exists:sc_confirm_register,membership_no,mem_confirm,1|max:6',
            'id_card' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'member_name' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no'])
            ],
            'member_surname' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'date_of_birth' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ]
        ];

        if (isset($req['password'])) {
            $password = $req['password'];
        
            $hasUppercase = preg_match('/[A-Z]/', $password);
            $hasLowercase = preg_match('/[a-z]/', $password);
            $hasNumber = preg_match('/[0-9]/', $password);
            $hasSpecialChar = preg_match('/[!@#$%^&*(),.?":{}|<>_+=]/', $password);
            $isValidLength = strlen($password) >= 8 && strlen($password) <= 15;
        
            $isValidPassword = $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar && $isValidLength;
        
            if (!$isValidPassword) {
                return response()->json(['error' => 'รูปแบบของรหัสผ่านไม่ถูกต้อง', 'membership_no' => null], 400);
            }
        }

        $validator = Validator::make($req, $rules, $this->messages());

        if ($validator->passes()) {
            //TODO Handle your data
            $envsecret = config('auth.SECRET_AUTH');

            $date = date('Y-m-d H:i:s');

            $user = User::where('membership_no', $req['membership_no'])
                ->update(array(
                    'mem_password' => $req['password'],
                    'mem_password_sha' => hash_hmac('sha256', $req['password'], $envsecret),
                    'mem_password_encrypt' => SoatEncode($req['password']),
                ));

                if ($resetPassStatus == 0 && $resetPassStatus != null) {
                    DB::table('sc_confirm_register')
                        ->where('membership_no', $membershipNo)
                        ->update(['password_reset_status' => 1]);
                }

            if ($user) {
                $arrayinsert = [
                    "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => $request->session()->token(),
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'web');

                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'เปลี่ยนรหัสผ่านสำเร็จ'
                ]);
            }
        } else {
            //TODO Handle your error
            $errors = $validator->errors()->all();

            $arrayinsert = [
                "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                "error_response" => $errors[0]
            ];
            // Add www_memregis_logs Mobile
            $this->SaveMemberregis_logs($request, $arrayinsert, 'forget_error', $req['membership_no'], 'web');

            return response()->json(compact('errors'));
        }
    }

    // เช็คเลขทะเบียนสมาชิก
    public function memberShipCheck(Request $request)
    {
        $check_mode = DB::table("www_constant")->pluck('member_maintenance')->first();
        if ($check_mode == 0) {
            $check_member_filter_used =  DB::select("SELECT *
                                                    FROM sm_member_filter_used
                                                    WHERE membership_no = '" . $request['membership_no'] . "'
                                                    AND web_member_active = 1");

            if (count($check_member_filter_used) == 0) {
                return response()->json([
                    'rc_code' => '-1',
                    'des' => "ขออภัยในความไม่สะดวก
ระบบอยู่ระหว่างการทดสอบ
ไม่สามารถใช้งานได้ชั่วคราว",
                ]);
            }
        }

        return $this->memberShipCheckTrait($request);
    }

    public function login(Request $request)
    {
        $check_mode = DB::table("www_constant")->pluck('member_maintenance')->first();
        $membershipNo = $request->input('membership_no');
        $resetPassStatus = DB::table('sc_confirm_register')
                                ->where('membership_no', $membershipNo)
                                ->pluck('password_reset_status')
                                ->first();
        // dd($membershipNo);
        // dd($resetPassStatus);
        // dd($check_mode);
        if ($check_mode == 0) {
            $check_member_filter_used =  DB::select("SELECT *
                                                    FROM sm_member_filter_used
                                                    WHERE membership_no = '" . $request->membership_no . "'
                                                    AND web_member_active = 1");

            if (count($check_member_filter_used) == 0) {
                return response()->json(['error' => 'ขออภัยในความไม่สะดวก
ระบบอยู่ระหว่างการทดสอบ
ไม่สามารถใช้งานได้ชั่วคราว', 'membership_no' => null], 400);
            }
        }

        if (
            method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)
        ) {
            $this->fireLockoutEvent($request);

            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            return response()->json(['error' => 'คุณได้พยายามเข้าระบบหลายครั้งเกินไป กรุณาลองใหม่ใน ' . $seconds . ' วินาทีข้างหน้า.'], 400);
        }

        if ($request->remember) {
            $ttl_in_minutes = 86400 * 30;
            $this->guard()->factory()->setTTl($ttl_in_minutes);
        }
        // dd($request->all());
        if ($request->recaptcha) {
            $secret = config('auth.recaptcha_secert');

            $recaptcha = new ReCaptcha($secret);
            $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request->recaptcha, $_SERVER['REMOTE_ADDR']);

            if ($resp->isSuccess()) {
                if (!$token = $this->guard()->attempt($this->credentials($request))) {
                    $this->incrementLoginAttempts($request);
                    return response()->json(['error' => 'เข้าสู่ระบบ ไม่สำเร็จ ชื่อผู้ใช้หรือรหัสผ่านผิด'], 401);
                }
            } else {
                return response()->json(['error' => 'ReCaptcha Unauthorized'], 401);
            }
        } else {
            if (!$token = $this->guard()->attempt($this->credentials($request))) {
                // $this->incrementLoginAttempts($request);
                return response()->json(['error' => 'เข้าสู่ระบบ ไม่สำเร็จ ชื่อผู้ใช้หรือรหัสผ่านผิด'], 401);
            }
        }

        if($resetPassStatus == 0 && $resetPassStatus != null) {
            return response()->json(['error' => 'เพื่อความปลอดภัยในการใช้งาน กรุณาเปลี่ยนรหัสผ่านใหม่', 'membership_no' => null,'reset_status'=>$resetPassStatus == 0 && $resetPassStatus != null], 406);
        }

        $this->clearLoginAttempts($request);

        $IP = f_get_ip();
        $today = date('Y-m-d H:i:s');
        $date = explode(' ', $today);
        $session_id = Session::getId();
        $agent = new Agent();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_ver = $agent->version($browser);
        $platform_ver = $agent->version($platform);
        // $OperatingSystems = $agent->getOperatingSystems();

        $client_name  = $device . " " . $browser . " " . $browser_ver . " on " . $platform . " " . $platform_ver;
        $data = $request->json()->all();
        DB::table('www_counter_member')
            ->insert(
                [
                    'ip_address' => $IP,
                    'visit_date' => $date[0],
                    'visit_time' => $date[1],
                    'session_id' => $session_id,
                    'membership_no' => $data['membership_no'],
                    'client_name' => $client_name
                ]
            );

        return $this->respondWithToken($token);
    }

    public function username()
    {
        return 'membership_no';
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
    }

    public function payload()
    {
        return response()->json($this->guard()->payload());
    }

    public function getAuthUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        // Token is valid and we have found the user via the sub claim
        return response()->json(['rc_code' => 1], 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'ออกจากระบบ เรียบร้อยแล้ว']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    protected function credentials(Request $request)
    {
        $req = $request->json()->all();
        return [
            $this->username() => $req['membership_no'],
            'password' => $req['mem_password'],
            'mem_confirm' => 1
        ];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $membership_no = $this->guard()->user()->membership_no;
        $user = SmMemMembershipRegistered::find($membership_no);

        return response()->json([
            'token' => $token,
            'member' => $user,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function messages()
    {
        return [
            'membership_no.required' => 'กรุณากรอก หมายเลขสมาชิก',
            'membership_no.exists' => 'สมาชิกเลขที่ :input นี้ ไม่ได้เป็นสมาชิก หรือยังไม่ได้เป็นสมาชิก',
            'membership_no.unique' => 'สมาชิกเลขที่ :input นี้ สมัครเป็นสมาชิกแล้ว',
            'membership_no.max' => 'จำนวน หมายเลขสมาชิก ไม่ถูกต้อง',
            'id_card.required' => 'กรุณากรอก หมายเลขบัตรประชาชน',
            'id_card.exists' => 'เลขบัตรประชาชน :input นี้ ไม่ตรงกับระบบ',
            'member_name.required' => 'กรุณากรอก ชื่อ',
            'member_name.exists' => 'ชื่อ :input นี้ ไม่ตรงกับระบบ',
            'member_surname.required' => 'กรุณากรอก นามสกุล',
            'member_surname.exists' => 'นามสกุล :input นี้ ไม่ตรงกับระบบ',
            'date_of_birth.required' => 'กรุณากรอก วันเกิด',
            'date_of_birth.exists' => 'วันเดือนปีเกิด ไม่ตรงกับระบบ',
        ];
    }
}
