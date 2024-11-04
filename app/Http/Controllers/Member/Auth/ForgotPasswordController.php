<?php

namespace App\Http\Controllers\Member\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    //use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:web');
    }

   /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('member.auth.re_register');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request['email'] = $request['mem_email'];
        
        $this->validator($request->all())->validate();

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validator(array $data)
    {

            $messages = [
                'membership_no.required' => 'โปรดกรอก เลขที่สมาชิก.',
                'membership_no.exists' => 'เลขที่สมาชิกไม่ถูกต้อง',
                'mem_id.required' => 'โปรดกรอก เลขบัตรประชาชน',
                'mem_id.exists' => 'เลขบัตรประชาชนไม่ถูกต้อง',
                'date_of_birth.required' => 'โปรดกรอก วันเกิด',
                'date_of_birth.exists' => 'วันเกิดไม่ถูกต้อง',
                'mem_email.required'=>'โปรดกรอก อีเมล',
                'mem_email.exists'=>'อีเมลไม่ถูกต้อง'
            ];

        $vali = Validator::make($data, [
                'membership_no' => ['required', 'string', 'max:255','exists:sc_confirm_register'],
                'mem_id' => ['required', 'string', 'max:255','exists:sc_confirm_register'],
                'date_of_birth' => ['required', 'string', 'max:255','exists:sc_confirm_register'],
                'mem_email' => ['required', 'string', 'email', 'max:255', 'exists:sc_confirm_register']
            ],$messages

        );

        return $vali;
    }
    protected function credentials(Request $request)
    {
        return $request->only('membership_no');
    }

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('message', trans($response));
    }

    public function broker()
    {
        return Password::broker('users');
    }


}
