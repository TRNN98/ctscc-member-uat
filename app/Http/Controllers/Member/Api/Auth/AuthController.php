<?php

namespace App\Http\Controllers\Member\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Member\Api\AuthRegisterTrait;
use App\Model\member\api\Member as User;
use App\Model\member\SmMemMembershipRegistered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Jenssegers\Agent\Agent;
use Laravel\Passport\Client;
use Lcobucci\JWT\Parser;
// use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use IssueTokenTrait;
    use AuthRegisterTrait;
    private $client;

    private $agent;

    private $IPADDRESS;

    public function __construct()
    {
        $this->client = Client::where('password_client', 1)->first();
        $agent = new Agent();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_ver = $agent->version($browser);
        $platform_ver = $agent->version($platform);
        // $OperatingSystems = $agent->getOperatingSystems();
        $this->agent  = $device . " " . $browser . " " . $browser_ver . " on " . $platform . " " . $platform_ver;
        $this->IPADDRESS = f_get_ip();
    }

    public function login(Request $request)
    {
        // $req = $request->json()->all();
        $this->validate($request, [
            'membership_no' => 'required|exists:sc_confirm_register|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0',
            'mem_password' => 'required'
        ], $this->messages());

        if (!Auth::attempt($this->credentials($request)))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);

        $this->addHistoryMember($request, 'login');

        return $this->issueToken($request, 'password');
    }

    /***********************ลงทะเบียน Mobile******************************************** */
    public function register(Request  $request)
    {
        $req = $request->json()->all();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|unique:sc_confirm_register|max:15',
            'id_card' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'date_of_birth' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'mem_password' => ["required"]
        ];
        $validator = Validator::make($req, $rules, $this->messages());
        if ($validator->passes()) {
            $member =  SmMemMembershipRegistered::find($req['membership_no']);
            $envsecret = config('auth.SECRET_AUTH');
            // dd($member);
            $date = date('Y-m-d H:i:s');

            $user = User::create([
                'membership_no' => $req['membership_no'],
                'mem_id' => $member->ID_CARD,
                'member_name' => $member->MEMBER_NAME,
                'member_surname' => $member->MEMBER_SURNAME,
                // 'mem_email' =>  $req['mem_email'],
                // 'phone_no' => $req['phone_no'],
                'mem_password_encrypt' => SoatEncode($req['mem_password']),
                'mem_password' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                // 'mem_password_sha' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                'mem_confirm' => 1,
                'operate_date' => $date,
                'terms_and_conditions_approve' => "1"
            ]);

            if ($user) {
                // ---------------------------
                $arrayinsert = [
                    "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => "",
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'register', $req['membership_no'], 'mobiles');
                // เพิ่ม Accept Pdpa
                $this->AddMemberAcceptPdpa($request, $req['membership_no'], "Mobiles");
                // --- Add Counter Member----------------------
                $this->addHistoryMember($request, 'register');
                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'ลงทะเบียนสำเร็จ'
                ]);
            } else {
                return response()->json([
                    'rc_code' => '0',
                    'messages' => 'ลงทะเบียนไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!'
                ], 500);
            }
        } else {
            $errors = $validator->errors()->all();

            $arrayinsert = [
                "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                "error_response" => $errors[0]
            ];
            // Add www_memregis_logs Mobile
            $this->SaveMemberregis_logs($request, $arrayinsert, 'regis', $req['membership_no'], 'mobiles');

            return response()->json([
                'rc_code' => '0',
                'messages' => $errors[0]
            ], 402);
        }

        // return $this->issueToken($request, 'password');
    }

    public function registerMobiles(Request  $request)
    {
        $req = $request->json()->all();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|unique:sc_confirm_register|max:15',
            'id_card' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'date_of_birth' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'mem_password' => ["required"]
        ];
        $validator = Validator::make($req, $rules, $this->messages());
        if ($validator->passes()) {
            // $member =  SmMemMembershipRegistered::find($req['membership_no']);
            $envsecret = config('auth.SECRET_AUTH');
            // dd($member->ID_CARD);
            $date = date('Y-m-d H:i:s');

            $user = User::create([
                'membership_no' => $req['membership_no'],
                // 'mem_id' => $member->ID_CARD,
                // 'member_name' => $member->MEMBER_NAME,
                // 'member_surname' => $member->MEMBER_SURNAME,
                // 'mem_email' =>  $req['mem_email'],
                'phone_no' => $req['phone_no'],
                'mem_password_encrypt' => SoatEncode($req['mem_password']),
                'mem_password' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                'mem_password_sha' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                'mem_confirm' => 1,
                'platform' => 'mobile',
                'operate_date' => $date,
                'terms_and_conditions_approve' => "1",
                'password_reset_status' => "2"
            ]);

            if ($user) {
                // ---------------------------
                $arrayinsert = [
                    "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => "",
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'register', $req['membership_no'], 'mobiles');
                // เพิ่ม Accept Pdpa
                $this->AddMemberAcceptPdpa($request, $req['membership_no'], "Mobiles");
                // --- Add Counter Member----------------------
                $this->addHistoryMember($request, 'register');
                return response()->json([
                    // 'rc_code' => '1',
                    'code' => '200REGISSUCCESS',
                    'messages' => 'ลงทะเบียนสำเร็จ'
                ]);
            } else {
                return response()->json([
                    // 'rc_code' => '0',
                    'code' => 'RESETPWD200',
                    'messages' => 'ลงทะเบียนไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!'
                ], 500);
            }
        } else {
            $errors = $validator->errors()->all();

            $arrayinsert = [
                "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                "error_response" => $errors[0]
            ];
            // Add www_memregis_logs Mobile
            $this->SaveMemberregis_logs($request, $arrayinsert, 'regis', $req['membership_no'], 'mobiles');

            return response()->json([
                'rc_code' => '0',
                'messages' => $errors[0]
            ], 402);
        }

        // return $this->issueToken($request, 'password');
    }

    /******************************************************************* */
    // ลืมรหัสผ่านของ Mobile 18/11/2564
    public function forget(Request $request)
    {
        $req = $request->json()->all();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|exists:sc_confirm_register,membership_no,mem_confirm,1|max:15',
            'id_card' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'date_of_birth' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'mem_password' => ["required"]
        ];

        // $this->validate($request, $rules, $this->messages());
        $validator = Validator::make($req, $rules, $this->messages());
        if ($validator->passes()) {
            //TODO Handle your data
            $envsecret = config('auth.SECRET_AUTH');

            $date = date('Y-m-d H:i:s');

            $user = User::where('membership_no', $req['membership_no'])
                ->update(array(
                    'mem_password_encrypt' => SoatEncode($req['mem_password']),
                    'mem_password' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    // 'mem_password_sha' => hash_hmac('sha256', $req['mem_password'], $envsecret)
                ));

            if ($user) {
                $arrayinsert = [
                    "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => $request->session()->token(),
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'mobiles');
                // --- Add Counter Member----------------------
                $this->addHistoryMember($request, 'forget');
                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'เปลี่ยนรหัสผ่านสำเร็จ'
                ]);
            } else {
                $arrayinsert = [
                    "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                    "error_response" => "ไม่สำเร็จ", "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'mobiles');


                return response()->json([
                    'rc_code' => '0',
                    'messages' => 'เปลี่ยนรหัสผ่านไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!'
                ], 500);
            }
        } else {
            $errors = $validator->errors()->all();

            $arrayinsert = [
                "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                "error_response" => $errors[0]
            ];
            // Add www_memregis_logs Mobile
            $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'mobiles');

            return response()->json([
                'rc_code' => '0',
                'messages' => $errors[0]
            ], 402);
        }

        // return $this->issueToken($request, 'password');
    }
    // -----------------------------------------------------
    public function forgetMobiles(Request $request)
    {
        $req = $request->json()->all();
        $rules = [
            'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|exists:sc_confirm_register,membership_no,mem_confirm,1|max:15',
            'id_card' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'date_of_birth' => [
                'required',
                'exists:sm_mem_m_membership_registered',
                Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
            ],
            'mem_password' => ["required"]
        ];

        // $this->validate($request, $rules, $this->messages());
        $validator = Validator::make($req, $rules, $this->messages());
        if ($validator->passes()) {
            //TODO Handle your data
            $envsecret = config('auth.SECRET_AUTH');

            $date = date('Y-m-d H:i:s');

            $user = User::where('membership_no', $req['membership_no'])
                ->update(array(
                    'mem_password_encrypt' => SoatEncode($req['mem_password']),
                    'mem_password' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    'mem_password_sha' => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    'password_reset_status' => '1'
                ));

            if ($user) {
                $arrayinsert = [
                    "step" => "3", "complete_status" => "1",
                    "SESSION_TOKEN" => $request->session()->token(),
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password']),
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'mobiles');
                // --- Add Counter Member----------------------
                $this->addHistoryMember($request, 'forget');
                return response()->json([
                    'rc_code' => '1',
                    'messages' => 'เปลี่ยนรหัสผ่านสำเร็จ'
                ]);
            } else {
                $arrayinsert = [
                    "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                    "error_response" => "ไม่สำเร็จ", "password_sha" => hash_hmac('sha256', $req['mem_password'], $envsecret),
                    "password" => SoatEncode($req['mem_password'])
                ];
                // Add www_memregis_logs Mobile
                $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'mobiles');


                return response()->json([
                    'rc_code' => '0',
                    'messages' => 'เปลี่ยนรหัสผ่านไม่สำเร็จ กรุณาลองใหม่อีกครั้ง!'
                ], 500);
            }
        } else {
            $errors = $validator->errors()->all();

            $arrayinsert = [
                "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $request->session()->token(),
                "error_response" => $errors[0]
            ];
            // Add www_memregis_logs Mobile
            $this->SaveMemberregis_logs($request, $arrayinsert, 'forget', $req['membership_no'], 'mobiles');

            return response()->json([
                'rc_code' => '0',
                'messages' => $errors[0]
            ], 402);
        }

        // return $this->issueToken($request, 'password');
    }
    public function logout(Request $request)
    {
        $value = $request->bearerToken();
        $id = (new Parser())->parse($value)->getClaim('jti');

        if (!$this->guard()->check() and $value) {
            DB::table('oauth_access_tokens')
                ->where('id', $id)
                ->update(['revoked' => true]);

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $id)
                ->update(['revoked' => true]);

            // $this->guard()->logout();

            return response()->json([
                'message' => 'Successfully logged out accessToken Expired'
            ], 200);
        } else {
            $accessToken = $this->guard()->user()->token();

            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update(['revoked' => true]);

            $accessToken->revoke();

            // $this->guard()->logout();

            return response()->json([
                'message' => 'Successfully logged out accessToken revoked'
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    public function refresh(Request $request)
    {
        $this->validate($request, [
            'refresh_token' => 'required'
        ]);

        $this->addHistoryMember($request, 'refresh');

        return $this->issueToken($request, 'refresh_token');
    }

    public function user()
    {
        return response()->json($this->guard()->user());
    }

    protected function credentials(Request $request)
    {
        $req = $request->json()->all();
        return [
            'membership_no' => $req['membership_no'],
            'password' => $req['mem_password']
        ];
    }

    protected function guard()
    {
        return Auth::guard('mobile-api');
    }

    public function messages()
    {
        return [
            'membership_no.required' => 'กรุณากรอก หมายเลขสมาชิก',
            'membership_no.exists' => 'สมาชิกเลขที่ :input นี้ ไม่ตรงกับระบบหรือยังไม่ได้ลงทะเบียน',
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

    private function addHistoryMember(Request $request, $type)
    {
        $req = $request->json()->all();

        $agent = new Agent();
        $agent->setUserAgent($request->userAgent());
        $agent->setHttpHeaders($request->headers);

        $today = date('Y-m-d H:i:s');
        $date = explode(' ', $today);
        $session_id = Session::getId();
        $device = $agent->device();
        $platform = $agent->platform();
        $browser = $agent->browser();
        $browser_ver = $agent->version($browser);
        $platform_ver = $agent->version($platform);
        $client_name  = $device . " " . $browser . " " . $browser_ver . " on " . $platform . " " . $platform_ver;

        DB::table('www_counter_member')
            ->insert(
                [
                    'ip_address' => $request->ip(),
                    'visit_date' => $date[0],
                    'visit_time' => $date[1],
                    'session_id' => $session_id,
                    'membership_no' => $req['membership_no'],
                    'client_name' => $client_name,
                    'type' => $type,
                    "device_type" => 'mobiles'
                ]
            );
    }
}
