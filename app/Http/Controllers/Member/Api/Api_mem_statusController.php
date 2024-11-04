<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManagerStatic as Image;

class Api_mem_statusController extends Controller
{
    public function Mem_status(Request $request)
    {
        $memstatus = DB::select("SELECT
            '1' AS rc_code,
            'success' AS rc_desc,
            FP_GET_MEMBER_NAME(membership_no) AS member_name,
            FP_GET_THAIDATE(date_of_birth) AS date_of_birth,
            FP_GET_AGE_TEXT(date_of_birth) AS age_text,
            (SELECT
                    CONCAT('สมาชิก', mem_type_desc)
                FROM
                    sm_mem_m_ucf_member_type
                WHERE
                    mem_type_code = regis.mem_type) AS mem_type_desc,
            (SELECT
                    share_stock
                FROM
                    sm_mem_m_share_mem
                WHERE
                    membership_no = regis.membership_no) AS share_stock,
            FP_GET_THAIDATE(approve_date) AS approve_date,
            FP_GET_AGE_TEXT(approve_date) AS mem_age_text,
            member_group_no,
            (SELECT
                    member_group_name
                FROM
                    sm_mem_m_ucf_member_group
                WHERE
                    member_group_no = regis.member_group_no) AS member_group_name,
            id_card,
            (CASE member_status_code
                WHEN '0' THEN 'เป็นสมาชิก'
                ELSE 'ขาดการเป็นสมาชิก'
            END) AS member_status_code,
            -- IFNULL(address_present, 'XX') AS address_present,
            -- COALESCE(phone_no, 'XX') AS phone_no,
            0 AS salary_amount,
            'null' AS position_name,
            '' AS email
        FROM
            sm_mem_m_membership_registered regis
        WHERE
            membership_no = :membership_no", ['membership_no' => Auth::user()->membership_no]);


        return response()->json($memstatus);
    }

    // For Webmember Page Status
    public function member_status()
    {
        $membership_no = Auth::user()->membership_no;

        $data1 = DB::select('SELECT
        sm_mem_m_membership_registered.membership_no	,
        sm_mem_m_membership_registered.prename	,
        sm_mem_m_membership_registered.member_name	,
        sm_mem_m_membership_registered.member_surname	,
        sm_mem_m_membership_registered.member_group_no	,
        sm_mem_m_membership_registered.member_group_name	,
        sm_mem_m_membership_registered.member_status_code,
        sm_mem_m_membership_registered.date_of_birth	,
        sm_mem_m_membership_registered.approve_date	,
        -- sm_mem_m_membership_registered.resignation_approve_date,
        CONCAT_WS("-", SUBSTR(sm_mem_m_membership_registered.id_card,1,1)
        ,SUBSTR(sm_mem_m_membership_registered.id_card,2,4)
        ,SUBSTR(sm_mem_m_membership_registered.id_card,6,5)
        ,SUBSTR(sm_mem_m_membership_registered.id_card,11,2)
        ,RIGHT(sm_mem_m_membership_registered.id_card,1))  AS id_card,
        sm_mem_m_membership_registered.sex,

        -- sm_mem_m_membership_registered.position_name,
        sm_mem_m_share_mem.period_recrieve,
        sm_mem_m_share_mem.share_stock,
        sm_mem_m_share_mem.share_amount,
        -- sm_mem_m_membership_registered.total_loan_int,
        sm_mem_m_ucf_position.position_name,
        sm_mem_m_membership_registered.salary_amount
        , sm_mem_m_membership_registered.address_present
        FROM 	sm_mem_m_membership_registered
        LEFT JOIN sm_mem_m_share_mem ON sm_mem_m_membership_registered.membership_no = sm_mem_m_share_mem.membership_no
        LEFT JOIN sm_mem_m_member_work_info ON sm_mem_m_membership_registered.membership_no = sm_mem_m_member_work_info.membership_no
        LEFT JOIN sm_mem_m_ucf_position ON sm_mem_m_member_work_info.position_code = sm_mem_m_ucf_position.position_code
        WHERE   1=1
        -- AND   sm_mem_m_membership_registered.membership_no = sm_mem_m_share_mem.membership_no
        AND	  sm_mem_m_membership_registered.membership_no = :membership_no ', ['membership_no' => $membership_no]);

        //dd($data1);
        $salary_amount = number_format($data1[0]->salary_amount, 2) . ' บาท';

        if ($data1[0]->sex == "M") {
            $sex = "ชาย";
        } else if ($data1[0]->sex == "F") {
            $sex = "หญิง";
        } else {
            $sex = "ไม่ได้ระบุ";
        }
        if ($data1[0]->member_status_code == 3) {
            $status = "ลาออก";
        } else {
            $status = "ปกติ";
        }

        //dd($data1[0]->sex);

        $principal_balance = DB::table('sm_lon_m_loan_card')
            ->where([
                ['membership_no', '=', $membership_no], ['principal_balance', '>', 0]
            ])
            ->sum('sm_lon_m_loan_card.principal_balance');

        $principal_balance = number_format($principal_balance);

        $deposit_balance = DB::table('sm_dep_m_creditor')
            ->select('deposit_balance')
            ->where([
                ['membership_no', '=', $membership_no],
                ['deposit_balance', '>', 0],
                ['close_status', '=', 0]
            ])->sum('deposit_balance');

        $deposit_balance = number_format($deposit_balance);

        // $prename = DB::table('sm_mem_m_ucf_prename')
        //     ->select('sm_mem_m_ucf_prename.prename')
        //     ->join(
        //         'sm_mem_m_membership_registered',
        //         'sm_mem_m_ucf_prename.prename_code',
        //         '=',
        //         'sm_mem_m_membership_registered.prename_code'
        //     )
        //     ->where('sm_mem_m_membership_registered.membership_no', '=', $membership_no)->get();

        if ($data1[0]->date_of_birth != null) {
            $date_of_birth = convert_to_Thaidate($data1[0]->date_of_birth) . " (" . calage($data1[0]->date_of_birth) . ")";
        } else {
            $date_of_birth = "ไม่ได้ระบุ";
        }


        if ($data1[0]->approve_date != null) {
            $approve_date = convert_to_Thaidate($data1[0]->approve_date) . " (" . calage($data1[0]->approve_date) . ")";
        } else {
            $approve_date = "ไม่ได้ระบุ";
        }

        return response()->json(compact('data1', 'principal_balance', 'deposit_balance', 'date_of_birth', 'approve_date', 'salary_amount'));
    }

    public function www_upload_profileimg(Request $request)
    {
        $req = $request->json()->all();
        $croppedAreaPixels = $req['croppedAreaPixels'];
        $croppedArea = $req['croppedArea'];
        // dd($croppedAreaPixels['height']);
        if (strlen($req['image']) > 100) {

            if (strpos($req['image'], "base64")) {
                $lenght = strpos($req['image'], "base64");
                $image64 = substr($req['image'], $lenght + 7);
            } else {
                $image64 = $req['image'];
            }
            try {
                $realImage = base64_decode($image64);
                $imageme = "member/profile/" . $req['name'] . ".jpg";
                file_put_contents($imageme, $realImage);
                // ------------------------------------------------------------------------------------------------------
                $width = 256; //*** Fix Width & Heigh (Autu caculate) ***//
                // $size = GetimageSize($imageme);
                $height = round($width * $croppedAreaPixels['height'] / $croppedAreaPixels['width']);
                try {
                    $img = Image::make($imageme);
                    $x = (int)$croppedAreaPixels['x'];
                    $y = (int)$croppedAreaPixels['y'];
                    $heightCrop = (int)$croppedAreaPixels['height'];
                    $widthCrop = (int)$croppedAreaPixels['width'];
                    $img->crop($widthCrop, $heightCrop, $x, $y);
                    $img->resize($width, $height);
                    $img->save($imageme);
                    $img->destroy();

                    //
                    $im = file_get_contents($imageme);
                    $base64encode = 'data:image/jpeg;name=' . $req['name'] . '.jpg;base64,' . base64_encode($im);
                } catch (\Throwable $th) {
                    return response()->json([
                        'rc_code' => '0',
                        'rc_des' => 'การอัพโหลดรูปส่วนตัวไม่สำเร็จ.. กรุณาลองใหม่อีกครั้ง..' . $th
                    ]);
                }
                return response()->json([
                    'rc_code' => '1',
                    'rc_des' => 'การอัพโหลดรูปส่วนตัวสำเร็จ',
                    'rc_resources' => $base64encode
                ]);
            } catch (Exception $e) {
                return response()->json([
                    'rc_code' => '0',
                    'rc_des' => 'การอัพโหลดรูปส่วนตัวไม่สำเร็จ.. กรุณาลองใหม่อีกครั้ง..' . $e
                ]);
            }
        }

        // --------------------------------------------------------------------------------------------------
    }



    public function ResizeImageByDir()
    {
        set_time_limit(0);
        $imagedir = "member/profile";
        $files = scandir($imagedir, 0);
        $filer_files = array_filter($files, function ($var) {
            if (strpos($var, ".jpg") > 0) {
                $imageme = "member/profile/" . $var;
                list($width, $height) = getimagesize($imageme);
                if ($width > 256 && $height > 256) {
                    return $var;
                }
            }
        });
        $images = [];
        foreach ($filer_files as $item) {
            $imageme = "member/profile/" . $item;
            $image_size = getimagesize($imageme);
            array_push($images, ["width" => $image_size[0], "height" => $image_size[1], "image" => $imageme]);
        }
        rsort($images);
        foreach ($images as $item) {
            $imageme = $item['image'];
            list($width, $height) = getimagesize($imageme);
            if ($width > 256 && $height > 256) {
                // ------------------------------------------------------------------------------------------------------
                $fixwidth = 256; //*** Fix Width & Heigh (Autu caculate) ***//
                $height = round($fixwidth * $height / $width);
                try {
                    $img = Image::make($imageme);
                    $img->resize($fixwidth, $height);
                    $img->save($imageme);
                    $img->destroy();
                } catch (\Throwable $th) {
                    return response()->json([
                        'rc_code' => '0',
                        'rc_des' => 'ไม่สามารถ Resize รูปได้' . $th
                    ]);
                }
            }
        }
    }

    
}
