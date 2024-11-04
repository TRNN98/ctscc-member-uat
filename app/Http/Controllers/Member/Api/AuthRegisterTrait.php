<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Model\member\api\Member as User;
use App\Model\member\SmMemMembershipRegistered;
use App\Model\member\www_memregis_logs;
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

trait AuthRegisterTrait
{

    // -------------------------- NEW REGISTER AND FORGET--------------------------------------------------------

    public function f_get_term_of_conditional_user($request)
    {
        $data = DB::select("SELECT Note from www_data where Category = 'term_of_conditional' limit 1 ");

        if ($data) {
            $data = $data[0];
            return response()->json(['rc_code' => '1', 'data' => $data->Note], 200);
        }
        return response()->json(['rc_code' => '0', 'data' => 'ไม่พบข้อมูลนโยบายความเป็นส่วนตัว', 'error' => 'ขออภัย ไม่พบข้อมูลนโยบายความเป็นส่วนตัวกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์ฯ'], 404);
    }
    // ---------------Policy----------------------------------------------
    public function f_get_policy($request)
    {
        $data = DB::select("SELECT Note from www_data where Category = 'policy' limit 1 ");

        if ($data) {
            $data = $data[0];
            return response()->json(['rc_code' => '1', 'data' => $data->Note], 200);
        }
        return response()->json(['rc_code' => '0', 'data' => 'ไม่พบข้อมูลนโยบายความเป็นส่วนตัว', 'error' => 'ขออภัย ไม่พบข้อมูลนโยบายความเป็นส่วนตัวกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์ฯ'], 404);
    }
    // ---------------Save Member regis logs----------------------------------------------
    public function SaveMemberregis_logs($request, $arrayinsert = [], $type, $membership_no, $device)
    {
        $storelogs = new www_memregis_logs;
        $storelogs->membership_no = $membership_no;
        $storelogs->step = $arrayinsert['step'] ?? null;
        $storelogs->type = $type;
        $storelogs->operate_date = DATETIME;
        $storelogs->complete_status = $arrayinsert['complete_status'] ?? null;
        $storelogs->agent = $request->server('HTTP_USER_AGENT');
        $storelogs->IP = $this->IPADDRESS;
        $storelogs->SESSION_TOKEN = $arrayinsert['SESSION_TOKEN'] ?? null;
        $storelogs->error_response = $arrayinsert['error_response'] ?? null;
        $storelogs->password_sha = $arrayinsert['password_sha'] ?? null;
        $storelogs->password = $arrayinsert['password'] ?? null;
        $storelogs->device = $device;
        return $storelogs->save();
    }
    // เพิ่ม PDPA Accepted3341600022512
    public function AddMemberAcceptPdpa($request, $membership_no, $device = "Web")
    {
        $insert_log = DB::table('www_member_accept_pdpa')->insert([
            'membership_no' => $membership_no, 'status' => '1', "operate_date" => DATE, "entry_date" => DATETIME, "IP" => $request->ip(),
            "agent" => $request->server('HTTP_USER_AGENT'), "device" => $device
        ]);
    }

    // ตรวจสอบเลขสมาชิกสหกรณ์ก่อน Step ที่  1
    public function memberShipCheckTrait($request)
    {
        $req = $request->json()->all();
        $membership_no = $req['membership_no'];
        $session_token = $request->session()->token();
        $type = $req['type'];
        $check_mode = DB::table("www_constant")->pluck('member_maintenance')->first();
        if ($check_mode == 0) {
            $check_member_filter_used =  DB::select("SELECT *
                                                    FROM sm_member_filter_used
                                                    WHERE membership_no = '" . $req['membership_no'] . "'
                                                    AND web_member_active = 1");
            // ถ้าผ่าน
            if (count($check_member_filter_used) == 1) {

                // return 1;
                // return response()->json(['code' => 'CWL0002ERROR', 'message' => 'Unauthenticated'], 401);
            }
            // ถ้าไม่ผ่าน
            else {
                return response()->json([
                    'rc_code' => 'notallow',
                    'des' => 'คุณยังไม่ได้รับสิทธิเข้าใช้งานสู่ระบบ กรุณาติดต่สหกรณ์',
                ]);
                // return 0;
                // return response()->json(['code' => 'CWL0002ERROR', 'message' => 'Unauthenticated'], 401);
            }
        } else {

            // return 1;
        }

        if ($req['type'] == 'register') {
            $rules = [
                'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|unique:sc_confirm_register|max:8'
            ];
        } else {
            $rules = [
                'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|max:8'
            ];
        }
        $validator = Validator::make($req, $rules, $this->messages());
        if ($request->_token == $session_token) {
            if ($validator->passes()) {
                if ($req['type'] == 'forget') {
                    $user = User::where('membership_no', $membership_no)->first();
                    if (!$user->membership_no) {
                        $des = 'เลขสมาชิก ' . $membership_no . ' ยังไม่ได้ลงทะเบียนกรุณาลงทะเบียนก่อนตอนขั้นตอน';
                        $arrayinsert = ["step" => "1", "complete_status" => "0", "SESSION_TOKEN" => null, "error_response" => $des];
                        $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');

                        return response()->json([
                            'rc_code' => '-1',
                            'des' => $des,
                        ]);
                    }
                }
                $envsecret = config('auth.SECRET_AUTH');
                $genToken = hash_hmac('sha256', $membership_no . rand(), $envsecret);
                session()->forget('memauth_token');
                session()->put('memauth_token', $genToken);


                // $storelogs = new www_memregis_logs;
                // $storelogs->membership_no = $membership_no;
                // $storelogs->step = '1';
                // $storelogs->type = $type;
                // $storelogs->operate_date = DATETIME;
                // $storelogs->complete_status = '1';
                // $storelogs->agent = $this->agent;
                // $storelogs->IP = $this->IPADDRESS;
                // $storelogs->SESSION_TOKEN = $genToken;

                $arrayinsert = ["step" => "1", "complete_status" => "1", "SESSION_TOKEN" => $genToken, "error_response" => null];
                $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');


                if ($storelogs) {
                    return response()->json([
                        'rc_code' => '1',
                        'des' => 'ยืนยันเลขทะเบียนสมาชิกสำเร็จ',
                        'token' => $genToken,
                        'data' => ['membership_no' => $membership_no]
                    ]);
                } else {
                    return response()->json([
                        'rc_code' => '0',
                        'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                    ]);
                }
            } else {
                //TODO Handle your error
                $errors = $validator->errors()->all();

                $arrayinsert = ["step" => "1", "complete_status" => "0", "SESSION_TOKEN" => null, "error_response" => $errors[0]];
                $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');


                // if ($storelogs->save()) {
                if ($storelogs) {
                    return response()->json([
                        'rc_code' => '-1',
                        'des' => $errors[0]
                    ]);
                } else {
                    return response()->json([
                        'rc_code' => '0',
                        'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                    ]);
                }
            }
        } else {
            return response()->json(['error' => 'การเชื่อมต่อไม่ถูกต้อง กรุณาเข้าสู่ระบบในช่องทางปกติ'], 401);
        }
    }
    // ตรวจสอบข้อมูลส่วยตัว Step ที่  2
    public function personalDataConfirmTrait($request)
    {
        $req = $request->json()->all();
        $session_token = $request->session()->token();
        $membership_no = $req['membership_no'];
        $type = $req['type'];
        $reactsessionToken = $req['sessiontoken'];
        $phpSessionToken = session()->get('memauth_token');
        if ($request->_token == $session_token) {
            if ($reactsessionToken  != $phpSessionToken) {
                return response()->json([
                    'rc_code' => '-2',
                    'des' => 'ขออภัย! กรุณายืนยันตัวตนใหม่อีกครั้ง',
                ]);
            } else {
                if ($req['type'] == 'register') {
                    $rules = [
                        'membership_no' => [
                            'required', 'exists:sm_mem_m_membership_registered,membership_no,member_status_code,0', 'unique:sc_confirm_register', 'max:15',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no'])
                        ],

                        'id_card' => [
                            'required',
                            'exists:sm_mem_m_membership_registered',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        ],
                        // 'member_name' => [
                        //     'required',
                        //     'exists:sm_mem_m_membership_registered',
                        //     Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        // ],
                        // 'member_surname' => [
                        //     'required',
                        //     'exists:sm_mem_m_membership_registered',
                        //     Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        // ],
                        'date_of_birth' => [
                            'required',
                            'exists:sm_mem_m_membership_registered',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        ],
                        // 'phone_no' => [
                        //     'required',
                        //     'exists:sm_mem_m_membership_registered',
                        //     Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        // ]
                    ];
                } else {
                    $rules = [
                        'membership_no' => [
                            'required', 'exists:sm_mem_m_membership_registered,membership_no,member_status_code,0', 'max:15',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no'])
                        ],

                        'id_card' => [
                            'required',
                            'exists:sm_mem_m_membership_registered',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        ],
                        // 'member_name' => [
                        //     'required',
                        //     'exists:sm_mem_m_membership_registered',
                        //     Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        // ],
                        // 'member_surname' => [
                        //     'required',
                        //     'exists:sm_mem_m_membership_registered',
                        //     Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        // ],
                        'date_of_birth' => [
                            'required',
                            'exists:sm_mem_m_membership_registered',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        ],
                        // 'phone_no' => [
                        //     'required',
                        //     'exists:sm_mem_m_membership_registered',
                        //     Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no']),
                        // ]
                    ];
                }

                $validator = Validator::make($req, $rules, $this->messages());
                if ($validator->passes()) {
                    // $storelogs = new www_memregis_logs;
                    // $storelogs->membership_no = $membership_no;
                    // $storelogs->step = '2';
                    // $storelogs->type = $type;
                    // $storelogs->operate_date = DATETIME;
                    // $storelogs->complete_status = '1';
                    // $storelogs->agent = $this->agent;
                    // $storelogs->IP = $this->IPADDRESS;
                    // $storelogs->SESSION_TOKEN = $phpSessionToken;

                    $arrayinsert = [
                        "step" => "2", "complete_status" => "1", "SESSION_TOKEN" => $phpSessionToken,
                        "error_response" => null
                    ];
                    $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');



                    // if ($storelogs->save()) {
                    if ($storelogs) {
                        return response()->json([
                            'rc_code' => '1',
                            'des' => 'ยืนยันเลขทะเบียนสมาชิกสำเร็จ',
                            'token' => $phpSessionToken,
                            'data' => [
                                'membership_no' => $membership_no, 'id_card' => $req['id_card'], 'member_name' => $req['member_name'], 'member_surname' => $req['member_surname'], 'date_of_birth' => $req['date_of_birth']
                            ]
                        ]);
                    } else {
                        return response()->json([
                            'rc_code' => '0',
                            'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                        ]);
                    }
                } else {
                    //TODO Handle your error
                    $errors = $validator->errors()->all();

                    // $storelogs = new www_memregis_logs;
                    // $storelogs->membership_no = $membership_no;
                    // $storelogs->step = '2';
                    // $storelogs->operate_date = DATETIME;
                    // $storelogs->type = $type;
                    // $storelogs->complete_status = '0';
                    // $storelogs->agent = $this->agent;
                    // $storelogs->IP = $this->IPADDRESS;

                    $arrayinsert = [
                        "step" => "2", "complete_status" => "0", "SESSION_TOKEN" => null,
                        "error_response" => $errors[0]
                    ];
                    $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');

                    // if ($storelogs->save()) {
                    if ($storelogs) {
                        return response()->json([
                            'rc_code' => '-1',
                            'des' => $errors[0]
                        ]);
                    } else {
                        return response()->json([
                            'rc_code' => '0',
                            'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                        ]);
                    }
                }
            }
        } else {
            return response()->json(['error' => 'การเชื่อมต่อไม่ถูกต้อง กรุณาเข้าสู่ระบบในช่องทางปกติ'], 401);
        }
    }
    // สำหรับเปลี่ยนรหัสผ่านสมาชิก "ลืมรหัสผ่าน" Step ที่ 3
    public function passwordConfirmTrait($request)
    {
        $req = $request->json()->all();
        $session_token = $request->session()->token();
        $membership_no = $req['membership_no'];
        $type = $req['type'];
        $reactsessionToken = $req['sessiontoken'];
        $phpSessionToken = session()->get('memauth_token');
        if ($request->_token == $session_token) {
            if ($reactsessionToken  != $phpSessionToken) {
                return response()->json([
                    'rc_code' => '-2',
                    'des' => 'ขออภัย! กรุณายืนยนตัวตนใหม่อีกครั้ง',
                ]);
            } else {
                if ($req['type'] == 'register') {
                    $rules = [
                        'membership_no' => [
                            'required', 'exists:sm_mem_m_membership_registered,membership_no,member_status_code,0',  'unique:sc_confirm_register', 'max:8',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no'])
                        ],
                    ];
                } else {
                    $rules = [
                        'membership_no' => [
                            'required', 'exists:sm_mem_m_membership_registered,membership_no,member_status_code,0', 'max:8',
                            Rule::exists('sm_mem_m_membership_registered')->where('membership_no', $req['membership_no'])
                        ],
                    ];
                }
                $validator = Validator::make($req, $rules, $this->messages());
                if ($validator->passes()) {
                    // $storelogs = new www_memregis_logs;
                    // $storelogs->membership_no = $membership_no;
                    // $storelogs->step = '3';
                    // $storelogs->type = $type;
                    // $storelogs->operate_date = DATETIME;
                    // $storelogs->complete_status = '1';
                    // $storelogs->agent = $this->agent;
                    // $storelogs->IP = $this->IPADDRESS;
                    // $storelogs->SESSION_TOKEN = $phpSessionToken;
                    $envsecret = config('auth.SECRET_AUTH');
                    $arrayinsert = [
                        "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => $phpSessionToken,
                        "error_response" => null, "password_sha" => hash_hmac('sha256', $req['password'], $envsecret),
                        "password" => SoatEncode($req['password'])
                    ];
                    $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');


                    $user = User::where('membership_no', $req['membership_no'])
                        ->update(array(
                            'mem_password' => hash_hmac('sha256', $req['password'], $envsecret),
                            'mem_password_encrypt' => SoatEncode($req['password']),

                        ));

                    if ($storelogs && $user) {
                        $user = SmMemMembershipRegistered::find($membership_no);
                        return response()->json([
                            'rc_code' => '1',
                            'des' => 'ยืนยันเลขทะเบียนสมาชิกสำเร็จ',
                            'token' => $phpSessionToken,
                            'data' => [$user]
                        ]);
                    } else {
                        return response()->json([
                            'rc_code' => '0',
                            'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                        ]);
                    }
                } else {
                    //TODO Handle your error
                    $errors = $validator->errors()->all();

                    // $storelogs = new www_memregis_logs;
                    // $storelogs->membership_no = $membership_no;
                    // $storelogs->step = '2';
                    // $storelogs->type = $type;
                    // $storelogs->operate_date = DATETIME;
                    // $storelogs->complete_status = '0';
                    // $storelogs->agent = $this->agent;
                    // $storelogs->IP = $this->IPADDRESS;

                    $arrayinsert = [
                        "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $phpSessionToken,
                        "error_response" => $errors[0]
                    ];
                    $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');


                    if ($storelogs) {
                        return response()->json([
                            'rc_code' => '-1',
                            'des' => $errors[0]
                        ]);
                    } else {
                        return response()->json([
                            'rc_code' => '0',
                            'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                        ]);
                    }
                }
            }
        } else {
            return response()->json(['error' => 'การเชื่อมต่อไม่ถูกต้อง กรุณาเข้าสู่ระบบในช่องทางปกติ'], 401);
        }
    }
    // คอนเฟริมลงทะเบียนเข้าใช้งานครั้งแรก Step ที่ 3
    public function registerConfirmTrait($request)
    {
        $req = $request->json()->all();
        $membership_no = $req['membership_no'];
        $type = $req['type'];
        $reactsessionToken = $req['sessiontoken'];
        $phpSessionToken = session()->get('memauth_token');
        if ($reactsessionToken  != $phpSessionToken) {
            return response()->json([
                'rc_code' => '-2',
                'des' => 'ขออภัย! กรุณายืนยันตัวตนใหม่อีกครั้ง',
            ]);
        } else {
            $rules = [
                'membership_no' => 'required|exists:sm_mem_m_membership_registered,membership_no,member_status_code,0|unique:sc_confirm_register|max:8'
            ];
            $validator = Validator::make($req, $rules, $this->messages());
            if ($validator->passes()) {
                $envsecret = config('auth.SECRET_AUTH');
                $accpt_status = 0;
                $accpt_timestamp = $req['accept_term_timestamp'];
                $acceptdatetime = date_create($accpt_timestamp);
                $converttodate = date_format($acceptdatetime, "Y-m-d");
                $converttoentry_date = date_format($acceptdatetime, "Y-m-d H:i:s");

                if ($req['accept_term_status']) {
                    $accpt_status = 1;
                }


                $arrayinsert = [
                    "step" => "3", "complete_status" => "1", "SESSION_TOKEN" => $phpSessionToken,
                    "error_response" => null, "password_sha" => hash_hmac('sha256', $req['password'], $envsecret),
                    "password" => SoatEncode($req['password'])
                ];
                $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');

                $user_info = SMMEMMEMBERSHIPREGISTERED::find($membership_no);

                $user = User::create([
                    'membership_no' => $req['membership_no'],
                    'mem_email' => null,
                    'mem_id' => $user_info->ID_CARD,
                    'member_name' => $user_info->MEMBER_NAME,
                    'member_surname' => $user_info->MEMBER_SURNAME,
                    'mem_password' => hash_hmac('sha256', $req['password'], $envsecret),
                    'mem_password_encrypt' => SoatEncode($req['password']),
                    'terms_and_conditions_approve' => $accpt_status,
                    'mem_confirm' => 1,
                    'operate_date' => DATETIME,
                ]);


                if ($storelogs && $user) {

                    $insert_log = DB::table('www_member_accept_pdpa')->insert([
                        'membership_no' => $membership_no, 'status' => '1',
                        "operate_date" => $converttodate,
                        "entry_date" => $converttoentry_date,
                        "IP" => $request->ip(), "agent" => $request->server('HTTP_USER_AGENT')
                    ]);

                    session()->forget('memauth_token');
                    $user = $user_info;
                    return response()->json([
                        'rc_code' => '1',
                        'des' => 'ลงทะเบียนสมาชิกสำเร็จ',
                        'token' => $phpSessionToken,
                        'data' => [$user]
                    ]);
                } else {
                    return response()->json([
                        'rc_code' => '0',
                        'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                    ]);
                }
            } else {
                //TODO Handle your error
                $errors = $validator->errors()->all();

                $arrayinsert = [
                    "step" => "3", "complete_status" => "0", "SESSION_TOKEN" => $phpSessionToken,
                    "error_response" => $errors[0], "password_sha" => null,
                    "password" => null
                ];
                $storelogs =   $this->SaveMemberregis_logs($request, $arrayinsert, $type, $membership_no, 'web');


                // $storelogs = new www_memregis_logs;
                // $storelogs->membership_no = $membership_no;
                // $storelogs->step = '3';
                // $storelogs->type = $type;
                // $storelogs->operate_date = DATETIME;
                // $storelogs->complete_status = '0';
                // $storelogs->agent = $this->agent;
                // $storelogs->IP = $this->IPADDRESS;

                if ($storelogs) {
                    return response()->json([
                        'rc_code' => '-1',
                        'des' => $errors[0]
                    ]);
                } else {
                    return response()->json([
                        'rc_code' => '0',
                        'des' => 'กำลังตรวจสอบข้อมูลสมาชิกไม่สำเร็จกรุณาลองใหม่อีกครั้งหรือติดต่อสหกรณ์',
                    ]);
                }
            }
        }
    }

    // -----------------------------------------------------------------------------------------------------------


}
