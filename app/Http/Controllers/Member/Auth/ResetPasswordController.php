<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\system\membership;
use Illuminate\Auth\Events\PasswordReset;
use ReCaptcha\ReCaptcha;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = 'member/mem';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string|null  $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('member.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);

        // $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    protected function setUserPassword($user, $password)
    {
        $envsecert = config('auth.SECRET_AUTH');
        $user->mem_password = hash_hmac('sha256',$password,$envsecert);
    }

    public function re_register(Request $request)
    {
        //dd($request->all());
        $recaptcha = new ReCaptcha(config('auth.recaptcha_secert'));
        $resp = $recaptcha->setExpectedHostname($_SERVER['SERVER_NAME'])->verify($request['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

        if($resp->isSuccess())
        {
            $member = new membership() ;
            $member->membership_no =  trim($request->member_id);
            $member->id_card        =  trim($request->mem_idcard);
            $member->name          =  trim($request->name);
            $member->surname     =  trim($request->surname);
            $member->password    =  trim($request->password);

            $y = trim(((int)$request->b_year) - 543);
            $m = trim($request->b_month);
            $d = trim($request->b_day);

            $member->birthday      =  $y.'-'.$m.'-'.$d;
            $member->shareMonthly = trim($request->shareMonthly);

            if($member->find_re_register())
            {
                f_message('หมายเลขสมาชิกกับเลขที่บัตรประชาชนที่ท่านระบุ ไม่ถูกต้อง!!!') ;
                f_goto('reset');
            }else{
                if($member->find_member())
                {
                if($member->check_id_card())
                {
                    if($member->check_birth_day_re_register())
                    {
                    if($member->check_name())
                    {
                        if($member->chk_member_status())
                        {
                            if($member->re_register())
                            {
                                f_message('แก้ไขรหัสผ่านเรียบร้อยแล้ว !!! ') ;
                                f_goto('../../member/mem'."?membership_no=".$member->membership_no) ;
                            } else {
                                f_message('แก้ไขรหัสผ่านไม่สำเร็จ !!! ') ;
                                f_goto('reset');
                            }
                        }else{
                            f_message("ไม่ใช่สมาชิกสถานปกติ !");
                            f_goto('reset');
                        }
                    }else{
                        f_message('ชื่อหรือนามสกุลที่ท่านระบุไม่ถูกต้อง !!!');
                        f_goto('reset');
                    }

                    }else{
                    f_message('วันเกิดที่ท่านระบุไม่ถูกต้อง !!!');
                    f_goto('reset');
                    }

                }else{
                    f_message('หมายเลขบัตรประชาชนที่ท่านระบุไม่ถูกต้อง !!');
                    f_goto('reset');
                }
                }else{
                f_message(' ไม่พบหมายเลขสมาชิกที่ท่านระบุ !!! ');
                f_message(' กรุณาติดต่อผู้ดูแลระบบ !!! ') ;
                f_goto('reset');
                }

            }

        }
    }

}
