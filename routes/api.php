<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

$api_version = config('api.api_version');

//  Mobile
Route::group(["prefix" => "{$api_version}", 'middleware' => 'mobile-api'], function () {
    Route::group(['prefix' => 'auth', 'namespace' => 'Member\Api\Auth'], function () {
        Route::post('login', 'AuthController@login');
        // Route::post('register', 'AuthController@registerMobiles');
        // Route::post('forget', 'AuthController@forgetMobiles');
        Route::post('registerMobiles', 'AuthController@registerMobiles');
        Route::post('forgetMobiles', 'AuthController@forgetMobiles');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('logout', 'AuthController@logout');
    });
    // Route::group(['prefix' => 'member/auth', 'namespace' => 'Member\Api\Auth'], function () {
    //     Route::post('registerMobiles', 'AuthController@registerMobiles');
    //     Route::post('forgetMobiles', 'AuthController@forgetMobiles');
    // });
    // pom move to top in namespace
    //   Route::post('/auth/registerMobile', 'AuthController@registerMobile');
    //   Route::post('/auth/forgetMobile', 'AuthController@forgetMobile');
    Route::group(['namespace' => 'Member\Api'], function () {
        // Route::post('/registerMobile', 'AuthController@registerMobile');
        // Route::post('/forgetMobile', 'AuthController@forgetMobile');
        Route::post('/notify', 'Api_mem_mobileController@notify');
        Route::post('/pdpa', 'Api_mem_mobileController@pdpa');
        Route::post('/versions', 'Api_mem_mobileController@versionupdate');
        Route::post('/address', 'Api_mem_mobileController@address');
        Route::post('/proadmin', 'Api_mem_mobileController@proadmin');
        Route::post('/checkfogetpassword', 'Api_mem_mobileController@checkfogetpassword');
        Route::post('/auths', 'Api_mem_mobileController@auth');
        Route::post('/upload', 'Api_mem_mobileController@upload');
        Route::post('/getNewToken', 'Api_mem_mobileController@getNewToken');
        Route::post('/deviceFollowMeStatus', 'Api_mem_mobileController@deviceFollowMeStatus');
        Route::get('/kep_print/{receive_year}/{receive_month}/{seq_no}/{token}', 'Api_mem_keep_detController@kepPrint');
        Route::get('/div_print', 'Api_mem_dividendController@print_loanreq');

        Route::get('/print_rec_pdf/{receipt_no}/{token}', 'Api_mem_keep_recController@recPrint');
        // Route::get('/kep_print_crem/{receive_year}/{receive_month}/{seq_no}/{token}', 'Api_mem_keep_detController@kepPrintCrem');
        // Route::get('/keep_rep_excel/{receive_year}/{receive_month}/{member_group}/{token}', 'Api_memgroup_keep_repController@print_excel');

        Route::post('/member/send_otp', 'Api_mem_mobileController@send_otp');
        Route::post('/member/verify_otp', 'Api_mem_mobileController@verify_otp');
    });

    Route::group(['prefix' => 'member', 'middleware' => 'auth:mobile-api'], function () {
        Route::group(['namespace' => 'Member\Api'], function () {
            Route::resource('member_changeshare', 'Api_mem_Change_share');
            // Route::post('/adminChare', 'Api_mem_mobileProController@AdminChare');
            /////////////////////////////////////////////
            // Web loann cal
            // Route::get('/loancal', 'Api_mem_loanCalController@index');
            // Route::post('/loanreqdata', 'Api_mem_loanCalController@RequestLoanReqInformation');
            // Route::post('/loanresloanreq', 'Api_mem_loanCalController@RequestLoanCal');
            // Route::post('/loanpayment_schdule', 'Api_mem_loanCalController@LoanPaymentSchedule');
            // // ดึงหักกลบ
            // Route::post('/loanreqgetsetoff', 'Api_mem_loanCalController@RequestListSetoffLoan');
            // // ประมวลหักกลบ
            // Route::post('/loanreqgetsetoffcalc', 'Api_mem_loanCalController@SetoffLoanCalc');
            /////////////////////////////////////////////
            //Route::resource('member_changeshare', 'Api_mem_Change_share');
            // Route::post('/info', 'Api_mem_mobileController@Info');
            // Route::resource('', 'Api_mem_Change_share');
            Route::post('/info', 'Api_mem_mobileController@Info');
            Route::post('/share', 'Api_mem_mobileController@Share');
            Route::post('/share_statement', 'Api_mem_mobileController@Share_statement');
            Route::post('/lon', 'Api_mem_mobileController@Lone');
            Route::post('/div', 'Api_mem_mobileController@div');
            Route::post('/rate', 'Api_mem_mobileController@rate');
            Route::post('/mem_coll', 'Api_mem_mobileController@mem_coll');
            Route::post('/gain', 'Api_mem_mobileController@gain');
            Route::post('/gain/loancal', 'Api_mem_receive_gainController@loancal');
            Route::post('/kept', 'Api_mem_mobileController@kept');
            Route::post('/kept_rec', 'Api_mem_mobileController@kept_rec');
            Route::post('/dep', 'Api_mem_mobileController@dep');
            Route::post('/msg', 'Api_mem_mobileController@msg');
            Route::post('/welfare', 'Api_mem_mobileController@welfare');
            Route::post('/userlogin', 'Api_mem_mobileController@userlogin');
            Route::post('/cremation', 'Api_mem_mobileController@Cremation');

            Route::get('/print_pdf/{receive_year}/{receive_month}', 'Api_mem_keep_detController@member_PrintKep');
            // Route::post('/div_print', 'Api_mem_dividendController@print_loanreq');

            // Route::get('/print_rec_pdf/{receipt_no}', 'Api_mem_keep_recController@member_PrintRec');
            // Route::get('/print_crem_pdf/{receive_year}/{receive_month}', 'Api_mem_keep_detController@member_PrintKepCrem');

            //////////////////////////////// Promoney ////////////////////////////////
            // Route::post('/AdminAll', 'Api_mem_mobileProController@AdminAll');
            Route::post('/deviceProStatus', 'Api_mem_mobileProController@deviceProStatus');
            Route::post('/checkToken', 'Api_mem_mobileProController@checkToken');
            Route::post('/insertHistory', 'Api_mem_mobileProController@insertHistory');
        });

        // ============ Promoney =========================
        Route::group(['namespace' => 'Promoney\Coop'], function () {
            // function ทีจะใช้
            Route::post('coop/oauth/token', 'AuthenticateController@token');
            Route::post('coop/account/inquiry', 'AccountController@inquiry');
            Route::post('coop/tranfer/inquiry', 'TransferController@inquiry');
            Route::post('coop/tranfer/confirmation', 'TransferController@confirmation');
            Route::post('coop/loanpayment/inquiry', 'PaymentController@inquiry');
            Route::post('coop/loanpayment/confirmation', 'PaymentController@confirmation');
            Route::post('coop/withdrawloan/inquiry', 'WithdrawLoanController@inquiry');
            Route::post('coop/withdrawloan/confirmation', 'WithdrawLoanController@confirmation');
            Route::post('coop/buyshare/inquiry', 'BuyshareController@inquiry');
            Route::post('coop/buyshare/confirmation', 'BuyshareController@confirmation');
            Route::post('coop/transaction/history', 'TransactionController@history');

            // Route::group(['prefix' => 'proadmin'], function () {
            //     Route::post('loanpermit', 'ProadminController@loanpermit');
            //     Route::post('loanpermitinstall', 'ProadminController@loanpermitinstall');
            //     Route::post('vdcngshare', 'ProadminController@validateChangeShare');
            // });
        });

        //  โอนภายนอก Krungthai Bank
        Route::group(['namespace' => 'Promoney\Bank\Ktb', 'prefix' => 'ktb'], function () {
            Route::post('account/inquiry', 'AccountController@inquiry');
            Route::post('linkaccount/inquiry', 'AccountController@inquiry');
            Route::post('linkaccount/unlink', 'AccountController@unlink');
            Route::post('deposit/inquiry', 'DepositController@inquiry');
            Route::post('deposit/confirmation', 'DepositController@confirmation');
            Route::post('withdrawloan/inquiry', 'WithdrawLoanController@inquiry');
            Route::post('withdrawloan/confirmation', 'WithdrawLoanController@confirmation');
            Route::post('withdrawdep/inquiry', 'WithdrawDepController@inquiry');
            Route::post('withdrawdep/confirmation', 'WithdrawDepController@confirmation');
            Route::post('buyshare/inquiry', 'BuyshareController@inquiry');
            Route::post('buyshare/confirmation', 'BuyshareController@confirmation');
            Route::post('loanpayment/inquiry', 'PaymentController@inquiry');
            Route::post('loanpayment/confirmation', 'PaymentController@confirmation');
        });
        // ============ Promoney =========================

    });
});

Route::get('/search_resize_dir', 'Member\Api\Api_mem_statusController@ResizeImageByDir');

Route::group(['namespace' => 'Member\Api', 'prefix' => 'member'], function () {
    Route::group(['middleware' => 'auth:api,admin'], function () {
        Route::post('/auth/logout', 'AuthController@logout');
        Route::post('/auth/refresh', 'AuthController@refresh');
        // Route::post('/auth/me', 'AuthController@me');

        Route::post('/auth/getAuthUser', 'AuthController@getAuthUser');
        // Route::post('/auth/getuser', 'AuthController@getUser');

        // Added
        Route::post('/wwwupload', 'Api_mem_statusController@www_upload_profileimg');

        // Route::post('/info', 'Api_mem_mobileController@Info');
        // Route::post('/share', 'Api_mem_mobileController@Share');
        // Route::post('/share_statement', 'Api_mem_mobileController@Share_statement');
        // Route::post('/lon', 'Api_mem_mobileController@Lone');
        // Route::post('/div', 'Api_mem_mobileController@div');
        // Route::post('/rate', 'Api_mem_mobileController@rate');
        // Route::post('/mem_coll', 'Api_mem_mobileController@mem_coll');
        // Route::post('/gain', 'Api_mem_mobileController@gain');
        // Route::post('/kept', 'Api_mem_mobileController@kept');
        // Route::post('/dep', 'Api_mem_mobileController@dep');
        // Route::post('/msg', 'Api_mem_mobileController@msg');
        // Route::post('/userlogin', 'Api_mem_mobileController@userlogin');
        // Route::post('/cremation', 'Api_mem_mobileController@Cremation');


        // For Web member
        Route::post('/member_status', 'Api_mem_statusController@member_status');
        Route::post('/member_share', 'Api_mem_share_statementController@member_share');
        Route::post('/searchMember_share', 'Api_mem_share_statementController@searchMember_share');
        Route::post('/member_loan', 'Api_mem_loanController@member_loan');
        Route::post('/member_loan_statement/{loan_statement}', 'Api_mem_loanController@member_loan_statement');
        Route::post('/member_dep', 'Api_mem_depositController@member_dep');
        Route::post('/member_dep_statement/{dep_statement}', 'Api_mem_depositController@member_dep_statement');
        Route::post('/member_kep', 'Api_mem_keep_detController@member_kep');
        Route::get('/print_pdf/{receive_year}/{receive_month}', 'Api_mem_keep_detController@member_PrintKep');
        Route::post('/member_coll', 'Api_mem_collController@member_coll');
        Route::post('/member_gian', 'Api_mem_receive_gainController@member_gian');
        Route::post('/member_div', 'Api_mem_dividendController@member_div');
        Route::post('/member_pass', 'Api_mem_AuthController@member_password');
        Route::post('/member_crem', 'Api_mem_cremController@member_crem');
    });

    // Route::post('/address', 'Api_mem_mobileController@address');
    // Route::post('/versions', 'Api_mem_mobileController@versionupdate');
    // Route::post('/checkfogetpassword', 'Api_mem_mobileController@checkfogetpassword');
    // Route::post('/auths', 'Api_mem_mobileController@auth');
    // Route::post('/upload', 'Api_mem_mobileController@upload');
    // Route::post('/reset', 'Api_mem_AuthController@reset');

    Route::post('/auth/login', 'AuthController@login');
    Route::post('/auth/register', 'AuthController@register');
    Route::post('/auth/forget', 'AuthController@forget');

    // Route::post('/auth/registerMobile', 'AuthController@registerMobile');
    // Route::post('/auth/forgetMobile', 'AuthController@forgetMobile');
});

Route::group(['prefix' => 'privacy-policy'], function () {
    Route::post('/cookies-policy', function (Request $request) {
        // $req = $request->json()->all();
        // dd($request->json()->all());
        if (!empty($request->_id) && !empty($request->content) && $request->mode == "update") {

            $content_decode = $request->content;

            $content_private_policy_decode = $request->content_private_policy;


            $site_url = $request->site_url;
            $coop_name = SoatDecode($request->coop_name);
            $save_json_array = array('content' => $content_decode, 'site_url' => $site_url, "coop_name" => $coop_name, "updated_date" => date('Y-m-d H:i:s'), "content_id" => SoatDecode($request->content_id));

            $save_private_policy_json_array = array('content' => $content_private_policy_decode, 'site_url' => $site_url, "coop_name" => $coop_name, "updated_date" => date('Y-m-d H:i:s'), "content_id" => SoatDecode($_POST['content_id']));

            // dd($save_json_array);
            // ---------
            add_log_active_update_cookies_policy($request);
            // ---------
            edit_content_pdpa($save_json_array);
            // ---------
            edit_content_pdpa_private_policy($save_private_policy_json_array);
            // dd($req);
            // ---------
            return response()->json(array('code' => "200FIRSTACTIVESUCCESS", "message" => "ส่งถึงปลายทางสำเร็จ", "data" => ["_id" => $request->_id]));
        } else if (!empty($request->_id) && $request->mode == "verify") {


            $cookie_json_file = storage_path('/app/pdpa/cookie-policy.json');
            if (!file_exists($cookie_json_file)) {
                return response()->json(array('code' => "404NoCookie", "message" => "ไม่มี Json ไฟล์", "data" => array()));
            }

            return response()->json(array('code' => "200VERIFYSUCCESS", "message" => "มี Json ไฟล์ Active แล้ว", "data" => ["_id" => $request->_id]));
        } else {

            return response()->json(array('code' => "NOMETHODALLOW", "message" => "Access Denied", "data" => array()));
        }
    });
});

// Web Info
// Route::group(['namespace' => 'Info\Api', 'prefix' => 'info'], function () {
//     // Matches Url The "api/info/" URL
//     Route::get('/auth/is_admin', 'Api_info_AuthController@is_admin');
//     Route::get('/home', 'Api_info_HomeController@index');
//     Route::get('/list/{Category}', 'Api_info_ListController@list');
//     Route::get('/download', 'Api_info_ListController@download');
//     Route::post('/list/search', 'Api_info_ListController@search');
//     Route::get('/show/{No}', 'Api_info_ShowController@show');
//     Route::get('/board', 'Api_info_BoardController@board_list');
//     Route::post('/board_create', 'Api_info_BoardController@board_create');
//     Route::get('/board_show/{No}', 'Api_info_BoardController@board_show');
//     Route::post('/board_ans', 'Api_info_BoardController@board_ans');
//     Route::get('/board_ans_del/{id}', 'Api_info_BoardController@board_ans_del');
//     Route::get('/board_del/{id}', 'Api_info_BoardController@board_del');
//     Route::get('/manu', 'Api_info_ManuController@manu');
// });
