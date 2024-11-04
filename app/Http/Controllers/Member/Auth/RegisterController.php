<?php

namespace App\Http\Controllers\Member\Auth;

use App\User;
use App\system\membership;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ReCaptcha\ReCaptcha;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

     /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('member.auth.register');
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'member/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        
        $recaptcha = new ReCaptcha(config('auth.recaptcha_secert'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
        
        if($resp->isSuccess())
        {
            $member = new membership() ;
            $member->membership_no =  $request->member_id ;
            $member->id_card        =  $request->mem_idcard ;
            $member->name          =  $request->name ;
            $member->surname     =  $request->surname ;
            $member->birthday      =  ($request->b_year-543)."-".$request->b_month."-".$request->b_day ; 
            $member->password    =  $request->password ;
            $member->email    =  $request->email ;

            if($member->find_register())
            {
                f_message('หมายเลขสมาชิกที่ท่านระบุ ได้ทำการลงทะเบียนไว้เรียบร้อยแล้ว ! ') ;
                f_goto("../../") ;
            }else{
            if($member->find_member())
            {
            if($member->check_id_card())
            {
                if($member->check_birth_day())
                {
                    if($member->check_name())
                    {
                    if($member->register())
                    {
                        f_message('ลงทะเบียนขอรหัสผ่านเรียบร้อยแล้ว สามารถเข้าใช้งานได้ทันที ! ') ;
                        f_goto("../../") ;
                    }
                    }else{
                    f_message('ชื่อหรือนามสกุลที่ท่านระบุไม่ถูกต้อง !');
                    f_goto($request_page);
                    }

                }else{
                f_message('วันเกิดที่ท่านระบุไม่ถูกต้อง !');
                f_goto($request_page);
                }

            }else{
                f_message('หมายเลขบัตรประชาชนที่ท่านระบุไม่ถูกต้อง !');
                f_goto($request_page);
            }
            }else{
            f_message(' ไม่พบหมายเลขสมาชิกที่ท่านระบุ ! ');
            f_message(' กรุณาติดต่อผู้ดูแลระบบ ! ') ;
            f_goto($request_page);
            }
            }
        }
    }   
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    // public function CallCheckCreditOtp()
    // {
    //     $Username	= "ohmpanucha";
    //     $Password	= "Panucha9012";
        
    //     $Parameter	=	"User=$Username&Password=$Password";
    //     $API_URL		=	"http://member.smsmkt.com/SMSLink/GetCredit/index.php";
        
    //     $ch = curl_init();   
    //     curl_setopt($ch,CURLOPT_URL,$API_URL);
    //     curl_setopt($ch,CURLOPT_RETURNTRANSFER,1); 
    //     curl_setopt($ch,CURLOPT_POST,1); 
    //     curl_setopt($ch,CURLOPT_POSTFIELDS,$Parameter);
        
    //     $Result = curl_exec($ch);
    //     $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
    //     curl_close($ch);
    //     echo($Result); 
    // }
}
