<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Group Info
// use App\Events\MyEvent;

// use App\Model\user\User;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;



// Route::get('/gen', 'MakeModifyWww_data@Update_path_dataFile');

Route::group(['namespace' => 'Info'], function () {

    Route::get('/', function () {
        //    return redirect('/index');
        return redirect('/logon');
    });

    // ===== เปลี่ยนรหัส md5 เป็นการเข้ารหัส sha256
    // Route::get('/hashing', function () {
    //     $user = User::all();
    //     foreach ($user as $h_mem) {

    //         $new_pass = User::find($h_mem->seq);
    //         $new_pass->mem_password_sha = hash_hmac('sha256', $h_mem->mem_password, config('auth.SECRET_AUTH'));
    //         $new_pass->save();
    //     }
    // });


    Route::get('/deploy', function () {
        // Artisan::call('key:generate');
        Artisan::call('cache:clear');
        Artisan::call('route:cache');
        Artisan::call('config:cache');
        Artisan::call('optimize:clear');
        Artisan::call('view:clear');
        // php artisan optimize:clear
        return "in CloudHM";
    });

    // Route::get('event', function () {
    //     event(new MyEvent("test","ttttttttttttttttttttttttttttttttttttttttttttttt", "445"));
    //     // broadcast(new MyEvent("testsetset"));
    // });
    // Route::get('qrcode', function () {
    //     return QrCode::size(250)->generate('XpertPhp');
    // });

    // Route::get('/debug-sentry', function () {
    //     throw new Exception('My first Sentry error!');
    // });

});

// Group Admin
Route::group(['namespace' => 'Admin', 'middleware' => 'antihack'], function () {

    Route::group(['prefix' => 'filemanager', 'middleware' => ['antihack', 'auth:admin']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });

    // Admin Auth Routes
    Route::get('adminlogon', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('adminlogon', 'Auth\LoginController@login');

    Route::get('admin/impersonate/destroy', 'Auth\ImpersonateController@destroy')->name('admin.impersonate.destroy');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::post('adminlogout', 'Auth\LoginController@logout')->name('admin.logout');

        Route::get('admin/impersonate/user/{membership_no}', 'Auth\ImpersonateController@index')->name('admin.impersonate');
        Route::get('admin/impersonate/auth/member', 'Auth\ImpersonateController@auth_member');

        Route::resource('ws_data_list', 'Ws_data_listController');
        Route::resource('ws_post', 'Ws_postController');
        Route::resource('ws_post_edit', 'Ws_post_editController');
        Route::resource('ws_category_control', 'Ws_category_controlController');
        Route::resource('ws_info', 'Ws_infoController');
        Route::resource('ws_constant', 'Ws_constantController');
        Route::resource('ws_login_state', 'Ws_login_stateController');
        Route::resource('ws_user_control', 'Ws_user_controlController');
        Route::resource('approve', 'ApproveController');
        Route::post('approve/feed_index', 'ApproveController@feed_index');
        Route::resource('ws_change_password', 'Ws_change_passwordController');

        Route::post('ws_change_password/changepassnewpassword', 'Ws_change_passwordController@changepassnewpassword')->name('admin.changepassnewpassword');
        Route::post('approve/delete_memconfirm', 'ApproveController@delete_memconfirm')->name('admin.approve.delete_memconfirm');

        Route::get('ws_member_registered', 'Ws_member_registeredController@index')->name('admin.ws_member_registered');
        Route::get('ws_member_registered/viewmember/{id}', 'Ws_member_registeredController@viewmember');
        Route::post('ws_member_registered/feed_index', 'Ws_member_registeredController@feed_index');

        Route::get('admin/control', 'ControlController@show');
        Route::post('searchControl', 'Ws_data_listController@searchControl')->name('admin.searchControl');
        Route::post('delete_img', 'Ws_post_editController@delete_img')->name('delete_img');
        Route::resource('ws_manu', 'Ws_manuController');

        // Mobile App Send Message msg ส่งข้อความถึงสมาชิกล่าสุด 10/2021 ใช้อันนี้
        Route::resource('mobile_send_message', 'Ws_mobile_send_messageController')->only([
            'index',
            'retreiveData',
            'store',
        ]);
        Route::resource('approve_mobile_message', 'Ws_approve_messageController');
        Route::post('mobile_send_message/retreive', 'Ws_mobile_send_messageController@retreiveData');
        // -------------------------------------------------------------------
        Route::post('approveMsg/feed_indexMemno', 'Ws_approve_messageController@feed_indexMemno');
        Route::post('approveMsg/feed_indexGroup', 'Ws_approve_messageController@feed_indexGroup');
        Route::post('approveMsg/feed_indexAll', 'Ws_approve_messageController@feed_indexAll');

        Route::post('ws_manu/deletedata', 'Ws_manuController@deletedata')->name('admin.manu.delete');
        Route::post('ws_user_control/deletedata', 'Ws_user_controlController@deletedata')->name('admin.usercontrol.delete');
        Route::post('ws_category_control/update', 'Ws_category_controlController@updatecategory')->name('admin.category.update');
        Route::post('ws_category_control/deletedata', 'Ws_category_controlController@deletedata')->name('admin.category.deletedata');
        // Route::post('ws_post/imageuploader','Ws_postController@imageuploader')->name('imageuploader');
        Route::post('upload_video', 'Ws_postController@upload_video');



        // ตัวควบคุมการเเสดงปันผลรายปี
        Route::resource('ws_approve_divinded', 'Ws_approve_divindedController');
        // ลายเซ็น
        Route::resource('ws_signature', 'Ws_signatureController');
        // สิทธิ์การอนุญาติใช้งาน ---------------------------------------------------------
        Route::resource('ws_sm_member_filter_used', 'Ws_sm_member_filter_usedController')->except('update');
        Route::post('ws_sm_member_filter_used/feed_index', 'Ws_sm_member_filter_usedController@feed_index');
        Route::post('ws_sm_member_filter_used/del', 'Ws_sm_member_filter_usedController@delete')->name('ws_sm_member_filter_used.del');
        Route::post('ws_sm_member_filter_used/update', 'Ws_sm_member_filter_usedController@update')->name('ws_sm_member_filter_used.update');

        // unlock mobile
        Route::resource('ws_unlock', 'Ws_unlockController');
        Route::post('ws_unlock/feed_index', 'Ws_unlockController@feed_index');
        Route::post('ws_unlock/delete_memconfirm', 'Ws_unlockController@delete_memconfirm')->name('admin.ws_unlock.delete_memconfirm');

        // unlock PinMobile
        Route::resource('ws_unlockpin', 'Ws_unlockpinController');
        Route::post('ws_unlockpin/feed_index', 'Ws_unlockpinController@feed_index');
        Route::post('ws_unlockpin/delete_memconfirm', 'Ws_unlockpinController@delete_memconfirm')->name('admin.ws_unlockpin.delete_memconfirm');

        Route::group(['prefix' => 'filemanager', 'middleware' => ['antihack', 'auth:admin']], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
            // App\unisharp\laravel-filemanager\Lrm::routes();
        });
        

    });
});



Route::get('/privacy-policy/cookies-policy', function () {

    //
    $path = 'pdpa/content/';
    // $fileName = storage_path($path . 'cookie-policy.json');
    $fileName = $path . 'cookie-policy.json';

    $retreieve_json_file =  Storage::get($fileName);
    $json = json_decode($retreieve_json_file);

    return view('privacy-policy.cookie-policy', compact('json'));
    });

    Route::get('/privacy-policy/private-policy', function () {

    //
    $path = 'pdpa/content/';
    // $fileName = storage_path($path . 'cookie-policy.json');
    $fileName = $path . 'private-policy.json';

    $retreieve_json_file =  Storage::get($fileName);
    $json = json_decode($retreieve_json_file);

    return view('privacy-policy.cookie-policy', compact('json'));
    });


Route::get('/{any}', function () {
    return view('index');
})->where('any', '.*');
