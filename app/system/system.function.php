<?php

use Illuminate\Support\Facades\Storage;



function f_get_ip()
{
    if ($_SERVER["HTTP_X_FORWARDED_FOR"])
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; //Check Proxy
    else
        $ip = $_SERVER["REMOTE_ADDR"];
    return $ip;
}

function fp_convert_ws_post_note($note, $url)
{
    // $pattern = "/\/coop\/ckeditor\/system\/plugins\/ckfinder\/upload\//i";
    $pattern = "/..\/coop\/FileManager\/uploads\//i";
    $result = preg_replace($pattern, $url . "/mediafiles/", $note);
    // $result = preg_replace($pattern,"../mediafiles/",$note);
    return $result;
}

function DangerModalalert($mes_head, $mes_des, $div_id, $page, $onclick = '')
{
    return '<div id="' . $div_id . '" class="modal modal-adminpro-general FullColor-popup-DangerModal fade" role="dialog">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-close-area modal-close-df">
                      <a class="close" data-dismiss="modal" href="#"><i class="fa fa-close"></i></a>
                  </div>
                  <div class="modal-body">
                      <span class="adminpro-icon adminpro-danger-error modal-check-pro information-icon-pro"></span>
                      <h2>' . $mes_head . '</h2>
                      <p>' . $mes_des . '</p>
                  </div>
                  <div class="modal-footer">
                      <a data-dismiss="modal" href="#">Cancel</a>
                      <a href="' . $page . '" onclick="' . $onclick . '">confirm</a>
                  </div>
              </div>
          </div>
      </div>';
}

function f_message($message)
{
    echo "<SCRIPT language=Javascript1.2>  alert('" . $message . "');</script>";
}

function f_mes($message, $type, $page)
{
    echo "<script type=\"text/javascript\">  $.notify({
                        message: \"" . $message . "\",
                        ";
    if ($type == success) {
        echo " icon: 'glyphicon glyphicon-user'";
    } else {
        echo " icon: 'glyphicon glyphicon-alert'";
    }
    echo "   },{
                              type: \"" . $type . "\",
                    animate: { enter: 'animated bounceInDown', exit: 'animated fadeInUp' },
                      placement: { from: 'top', align: 'center' }
                    });";
    if (isset($page)) {
        echo "
                            setTimeout(function () {
                              location.replace('$page');
                            }, 2000); ";
    }
    echo "
                      </script>";
}

function f_goto($page)
{
    echo "<script language='JavaScript' type='text/javascript'>
  <!--
  // Use location.replace function to avoid Back button trapping
  location.replace('$page');
    // -->
  </script>";
}

function convert_to_Thaidate($date)
{
    $date =  explode("-", $date);
    $mon = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
    $txt = $date[2] . " " . ($mon[(int) $date[1]]) . " " . ($date[0] + 543);
    return $txt;
}

function convert_date($date)
{
    $date =  explode("/", $date);
    $mon = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
    $txt = $date[0] . " " . ($mon[(int) $date[1]]) . " " . ($date[2] + 543);
    return $txt;
}

function convert_month($month)
{
    $mon = array('', 'ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
    $txt = $mon[(int) $month];
    return $txt;
}

function convert_full_month($month)
{
    $full_month_th   = array('', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
    $txt = $full_month_th[(int) $month];
    return $txt;
}

function calage($pbday)
{
    $today = date("d/m/Y");
    $year_age = 0;
    $month_age = 0;
    list($approve_y, $approve_m, $approve_d) = explode("-", $pbday);
    $approve_dd = substr($approve_d, 0, 2);
    list($tday, $tmonth, $tyear) = explode("/", $today);
    if ($approve_y < 1970) {
        $yearad = 1970 - $approve_y;
        $approve_y = 1970;
    } else {
        $yearad = 0;
    }
    $mbirth = mktime(0, 0, 0, $approve_m, $approve_dd, $approve_y);
    $mnow = mktime(0, 0, 0, $tmonth, $tday, $tyear);
    $mage = ($mnow - $mbirth);
    $year_age = (date("Y", $mage) - 1970 + $yearad);
    $month_age = (date("m", $mage) - 1);
    if ($year_age > 0) {
        $age_year = $year_age . "&nbsp;ปี&nbsp;";
    }
    if ($month_age > 0) {
        $age_month = $month_age . "&nbsp;เดือน";
    }
    $age = $age_year . $age_month;
    return ($age);
}

//GET SHOW PAGE For Admin
function f_get_page($page = null)
{
    if (empty($page)) {
        $return_page  = app('App\Http\Controllers\Admin\Ws_mainController')->index();
        return $return_page;
    } else {
        $pageup = ucfirst($page);
        $return_page  = app('App\Http\Controllers\Admin\\' . $pageup . 'Controller')->index();

        return $return_page;
    }
}

function f_get_category_description($_category_id)
{
    $description = DB::select('SELECT description FROM www_ucf_category WHERE category= :category', ['category' => $_category_id]);
    return ($description[0]->description);
}

function f_get_coop_name()
{
    $coopname = DB::table('www_constant')->first();
    return $coopname->coop_name;
}

function f_marquee($category, $limit = 1, $show_title = false)
{
    $GLOBALS['fdbo']->query_string = "SELECT  * from www_data WHERE Category='$category' ORDER BY No DESC LIMIT 0,$limit ";
    $GLOBALS['fdbo']->query();
    echo  "<marquee behavior='scroll' direction='left' scrollamount='5'>";
    while ($row = $GLOBALS['fdbo']->fetch_array()) {
        $keyword = array("<p>", "</p>", "");

        if ($show_title != false) {
            $status_detail    =    str_replace($keyword, "", $row['Question']);
            echo $status_detail . "  ";
        }
        $status_detail  =   strip_tags($row['Note']);
        $status_detail    =    str_replace("&nbsp;", "", $status_detail);
        // echo "โปรดทราบ!!! ขณะนี้สหกรณ์ได้ยกเลิกการส่งใบเสร็จทางไปรษณีย์แล้ว สมาชิกสามารถดูรายละเอียดและพิมพ์ได้ด้วยตนเองเพียงลงทะเบียน เข้าระบบสหกรณ์ ในเว็บไซต์นี้" ;
        echo $status_detail;
    }
    echo "</marquee>";
}

/**
 * Get Security User Information
 * @param mixed $field  , mixed $username
 * @return security user infomation array[]
 */

function CvnEngToThaiMoney($number)
{
    $txtnum1 = array('ศูนย์', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า', 'สิบ');
    $txtnum2 = array('', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน');
    $number = str_replace(",", "", $number);
    $number = str_replace(" ", "", $number);
    $number = str_replace("บาท", "", $number);
    $number = explode(".", $number);
    if (sizeof($number) > 2) {
        return 'ทศนิยมหลายตัวนะจ๊ะ';
        exit;
    }
    $strlen = strlen($number[0]);
    $convert = '';
    for ($i = 0; $i < $strlen; $i++) {
        $n = substr($number[0], $i, 1);
        if ($n != 0) {
            if ($i == ($strlen - 1) and $n == 1) {
                $convert .= 'เอ็ด';
            } elseif ($i == ($strlen - 2) and $n == 2) {
                $convert .= 'ยี่';
            } elseif ($i == ($strlen - 2) and $n == 1) {
                $convert .= '';
            } else {
                $convert .= $txtnum1[$n];
            }
            $convert .= $txtnum2[$strlen - $i - 1];
        }
    }
    $convert .= 'บาท';
    if ($number[1] == '0' or $number[1] == '00' or $number[1] == '') {
        $convert .= 'ถ้วน';
    } else {
        $strlen = strlen($number[1]);
        for ($i = 0; $i < $strlen; $i++) {
            $n = substr($number[1], $i, 1);
            if ($n != 0) {
                if ($i == ($strlen - 1) and $n == 1) {
                    $convert .= 'เอ็ด';
                } elseif ($i == ($strlen - 2) and $n == 2) {
                    $convert .= 'ยี่';
                } elseif ($i == ($strlen - 2) and $n == 1) {
                    $convert .= '';
                } else {
                    $convert .= $txtnum1[$n];
                }
                $convert .= $txtnum2[$strlen - $i - 1];
            }
        }
        $convert .= 'สตางค์';
    }
    return $convert;
}


function submenu($category)
{
    $output = '';
    $sub_menu = DB::table('www_data')->where('Category', $category)->orderBy('No', 'asc')->get();

    $output .= '<ul>';

    foreach ($sub_menu as $key) {

        $output .= '<li>';
        $output .=    '<a class="colorblack" href="' . url("show", $key->No) . '">' . $key->Question . '</a>';
        $output .= '</li>';
    }

    $output .= '</ul>';

    return $output;
}

function findNoByCategory($category)
{
    $findNo = DB::table('www_data')->where('Category', $category)->first('No');
    return (int) $findNo->No;
}

function board_detail_answer($no)
{
    $output = '';
    $board_ans = DB::table('www_board_ans')->where('QuestionNo', $no)->orderBy('No', 'asc')->get();

    if (count($board_ans) > 0) {
        $count = 1;
        foreach ($board_ans as $ans) {
            $date = explode(' ', $ans->Date);
            $settime = explode(':', $date[1]);
            $time = ' เวลา ' . $settime[0] . ':' . $settime[1] . ' น.';

            $output .= '<div class="board_detail_ans" style="padding:20px; margin:0 0 20px 55px; box-shadow:4px 3px 10px 0px #03030361; background-color:#f5f5f5;">';

            $output .= '  <p>ความคิดเห็นที่ ' . $count;

            if (Auth::guard('admin')->check()) {

                $output .= '    <span style="display:none;">' . $ans->No . '</span>';
                $output .= '    <i id="btndel-board-ans" class="pull-right fa fa-trash-o" style="font-size:24px; cursor:pointer;color:black;padding-right:30px;"></i>';
            }

            $output .= '  </p>';
            $output .= '  <hr stlye="border:1px solid #ddd;"> <h3>' . $ans->Msg . '</h3> <hr stlye="border:1px solid #ddd;">';
            $output .= '  <h6>โดย:' . $ans->Name . '</h6>';
            $output .= '  <h6><i class="fa fa-clock-o"></i>&nbsp;เมื่อวันที่ : ' . convert_to_Thaidate($date[0]) . $time;

            if (Auth::guard('admin')->check()) {
                $membership_no = $ans->Namer != 'Admin' ? 'เลขสมาชิก : ' . $ans->Namer : 'Admin';
                $output .= '  <span class="pull-right text-danger">[ IP : ' . $ans->IP . ' ] [ ' . $membership_no . ' ] </span>';
            }

            $output .= '  </h6>';

            $count++;

            $output .= '</div>';
        }
    } else {
        $output .= '<div class="board_detail_ans" style="padding:20px; margin:20px; box-shadow:4px 3px 10px 0px #03030361; background-color:#f5f5f5;">';
        $output .= '    <h6>ยังไม่มีการแสดงความคิดเห็น...</h6>';
        $output .= '</div>';
    }

    return $output;
}


// Used Memder
function Lpad($str, $text = "0", $length = 7)
{
    $lPad = str_repeat($text, $length) . $str;
    return substr($lPad, ((int) $length * -1), (int) $length);
}

// GET MEMEBER FULL NAME
function f_get_full_name($ag_membership_no)
{

    //***** ใช้ SC_MEM ในการ test (แต่ตัวจริงต้องใช้ SM_MEM)*********/
    $result = DB::table('sm_mem_m_membership_registered')
        ->join('sm_mem_m_ucf_prename', 'sm_mem_m_membership_registered.prename_code', '=', 'sm_mem_m_ucf_prename.prename_code')
        ->select('sm_mem_m_ucf_prename.prename', 'sm_mem_m_membership_registered.MEMBER_NAME', 'sm_mem_m_membership_registered.MEMBER_SURNAME')
        ->where('sm_mem_m_membership_registered.MEMBERSHIP_NO', '=', $ag_membership_no)
        ->first();

    $full_name = $result->prename . $result->MEMBER_NAME . " " . $result->MEMBER_SURNAME;
    return $full_name;
}

function CheckVulgar($str)
{
    // echo "<meta charset='utf-8'>"; //ให้แสดงข้อความภาษาไทย
    $wordrude = array(
        '/มึง/', '/กู/', '/ควย/', '/ควาย/', '/เหี้ย/', '/พ่อมึงตาย/', '/หี/', '/โง่/', '/กระจอก/', '/สัด/', '/สัส/', '/เย็ด/',
        '/ปี้/', '/โคตร/', '/เปรต/', '/สวะ/', '/แม่มึงตาย/', '/กระหรี่/', '/กระดอ/', '/กระโปรก/', '/กระโปก/', '/จิ๋ม/', '/จู๋/', '/แตด/', '/อีดอก/', '/ดอกทอง/'
    );
    $wordchange = "***";

    for ($i = 0; $i < count($wordrude); $i++) {
        $str = preg_replace($wordrude[$i], "***", $str);
    }

    return $str;
}

function countBoardAns($id)
{
    //count board_ans
    $count_ans = DB::table('www_board')
        ->join('www_board_ans', 'www_board.No', '=', 'www_board_ans.QuestionNo')
        ->select('www_board_ans.QuestionNo')
        ->where('www_board.No', '=', $id)->count();

    return $count_ans;
}

function f_get_mem_receive_dividend()
{
    $rec_div = DB::table('www_constant')->pluck('mem_receive_dividend')->first();

    if (count($rec_div) > 0) {
        return (int) $rec_div;
    } else return false;
}

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    $os_array = array(
        '/windows nt 6.2/i'     =>  'Windows 8',
        '/windows nt 6.1/i'     =>  'Windows 7',
        '/windows nt 6.0/i'     =>  'Windows Vista',
        '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
        '/windows nt 5.1/i'     =>  'Windows XP',
        '/windows xp/i'         =>  'Windows XP',
        '/windows nt 5.0/i'     =>  'Windows 2000',
        '/windows me/i'         =>  'Windows ME',
        '/win98/i'              =>  'Windows 98',
        '/win95/i'              =>  'Windows 95',
        '/win16/i'              =>  'Windows 3.11',
        '/macintosh|mac os x/i' =>  'Mac OS X',
        '/mac_powerpc/i'        =>  'Mac OS 9',
        '/linux/i'              =>  'Linux',
        '/ubuntu/i'             =>  'Ubuntu',
        '/iphone/i'             =>  'iPhone',
        '/ipod/i'               =>  'iPod',
        '/ipad/i'               =>  'iPad',
        '/android/i'            =>  'Android',
        '/blackberry/i'         =>  'BlackBerry',
        '/webos/i'              =>  'Mobile'
    );

    foreach ($os_array as $regex => $value) {
        if (preg_match($regex, $u_agent)) {
            $platform    =   $value;
        }
    }

    //First get the platform?
    // if (preg_match('/linux/i', $u_agent)) {
    //     $platform = 'linux';
    // } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
    //     $platform = 'mac';
    // } elseif (preg_match('/windows|win32/i', $u_agent)) {
    //     $platform = 'windows';
    // }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Trident/i', $u_agent)) { // this condition is for IE11
        $bname = 'Internet Explorer';
        $ub = "rv";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    // Added "|:"
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/|: ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function random_char($len)
{
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $ret_char = "";
    $num = strlen($chars);
    for ($i = 0; $i < $len; $i++) {
        $ret_char .= $chars[rand() % $num];
        $ret_char .= "";
    }
    return $ret_char;
}

function SoatEncode($pass)
{
    $spass = "";
    $string = $pass;
    $array = str_split($string);

    $len = "";
    foreach ($array as $p) {
        $len = strlen(ord($p));

        if ($len < 3) {
            $spass = $spass . base_convert("0" . ord($p), 10, 26);
        } else {
            $spass = $spass . base_convert(ord($p), 10, 26);
        }
    }

    $skey = "";
    $key = random_char((date("s") / 4) + 1);
    $arraykey = str_split($key);
    $lenkey = "";
    foreach ($arraykey as $k) {
        $lenkey = strlen(ord($k));
        if ($lenkey < 3) {
            $skey = $skey . base_convert("0" . ord($k), 10, 23);
        } else {
            $skey = $skey . base_convert(ord($k), 10, 23);
        }
    }
    return $skey . 'x' . $spass;
}


function SoatDecode($pass){
    $k[] = explode("x", $pass);
    $i = 0;
    $sdk = "";
    $sde = "";
    foreach (str_split($k[0][1]) as $s){
        if($i == 0){
            $sde = $sde.$s;
            $i++;
        }else{
            $sde = $sde.$s;
             $sdk =     strlen(base_convert($sde , 26 ,10)) < 3 ?
                    strlen(base_convert($sde , 26 ,10)) == 2 ?
                    $sdk."0".base_convert($sde , 26 ,10):
                    $sdk."00".base_convert($sde , 26 ,10)
                    :$sdk.base_convert($sde , 26 ,10);
            $sde = "";
            $i = 0;
        }
    }
    $i1 = 0;
    $sdk1 = "";
    $sde1 = "";
    foreach (str_split($sdk) as $s1){
        if($i1 == 0 || $i1 == 1){
            $sde1 = $sde1.$s1;
            $i1++;
        }
        else{
            $sde1 = $sde1.$s1;
            $sdk1 = $sdk1.chr($sde1);
            $sde1 = "";
            $i1 = 0;
        }
     }
     return  $sdk1;
}

function sendAll($msg)
{
    $content = array(
        "en" => $msg,
    );
    $hashes_array = array();
    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com",
    ));
    array_push($hashes_array, array(
        "id" => "like-button-2",
        "text" => "Like2",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com",
    ));
    $fields = array(
        'app_id' => "95bfc699-c4df-45a0-8173-529eef8df1e5",
        'included_segments' => array(
            'All',
        ),
        'data' => array(
            "foo" => "bar",
        ),
        'contents' => $content,
        'web_buttons' => $hashes_array,
    );

    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NGM5ZTJlNzAtNWIzMy00ZGFiLWI2MmEtYjg1Yjk4YTAxODlk',
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendSingle($title,$msg, $single)
{
    $content = array(
        "en" => "$msg",
    );

    $headings = array(
        "en" => "$title",
    );

    $fields = array(
        'app_id' => "95bfc699-c4df-45a0-8173-529eef8df1e5",
        'filters' => array(array("field" => "tag", "key" => "membership_no", "relation" => "=", "value" => "$single")),
        'data' => array("foo" => "bar"),
        'contents' => $content,
    );

    $fields = json_encode($fields);
    // print("\nJSON sent:\n");
    // print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic NGM5ZTJlNzAtNWIzMy00ZGFiLWI2MmEtYjg1Yjk4YTAxODlk'),);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

function sendMulti($title, $msg, $multi)
{
    $content = array(
        "en" => "$msg",
    );

    $headings = array(
        "en" => "$title",
    );
    $fields = array(
        'app_id' => "95bfc699-c4df-45a0-8173-529eef8df1e5",
        'filters' => $multi,
        'data' => array("foo" => "bar"),
        'contents' => $content,
        'headings' => $headings,
    );

    $fields = json_encode($fields);
    // print("\nJSON sent:\n");
    // print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8', 'Authorization: Basic NGM5ZTJlNzAtNWIzMy00ZGFiLWI2MmEtYjg1Yjk4YTAxODlk'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}



function edit_content_pdpa_private_policy($data)
{
    //
    $path = 'pdpa/content/';
    // $fileName = storage_path($path . 'cookie-policy.json');
    $fileName = $path . 'private-policy.json';
    if (Storage::missing($fileName)) {
        Storage::makeDirectory('pdpa/content');
        // mkdir(storage_path('/app/pdpa'), 0755);
    }
    // $readFile = fopen($fileName, "w") or die("Unable to create file!");
    // fwrite($readFile, json_encode($data));
    Storage::delete($fileName);
    Storage::put($fileName, json_encode($data));
    // fclose($readFile);
    return true;
}





function edit_content_pdpa($data)
{
    //
    $path = 'pdpa/content/';
    // $fileName = storage_path($path . 'cookie-policy.json');
    $fileName = $path . 'cookie-policy.json';
    if (Storage::missing($fileName)) {
        Storage::makeDirectory('pdpa/content');
        // mkdir(storage_path('/app/pdpa'), 0755);
    }
    // $readFile = fopen($fileName, "w") or die("Unable to create file!");
    // fwrite($readFile, json_encode($data));
    Storage::delete($fileName);
    Storage::put($fileName, json_encode($data));
    // fclose($readFile);
    return true;
}


function add_log_active_update_cookies_policy($data)
{
    $path = 'pdpa/logger/';
    $fileName = $path . 'active-cookies-policy.txt';

    // dd($fileName);
    if (Storage::missing($fileName)) {
        Storage::makeDirectory('pdpa/logger');
        $text  = date('Y-m-d H:i:s') . ' ส่งจาก ' . $_SERVER['HTTP_REFERER'] . ' รหัสเนื้อหา : ' . SoatDecode($data['content_id']) . ' ชื่อ ' . SoatDecode($data['coop_name']) . "\n";
        // fwrite($readFile, $text);
        // fclose($readFile);
        Storage::put($fileName, $text);

        return true;
    } else {
        $oldlog = Storage::get($fileName);
        $text  = $oldlog . date('Y-m-d H:i:s') . ' ส่งจาก ' . $_SERVER['HTTP_REFERER'] . ' รหัสเนื้อหา : ' . SoatDecode($data['content_id']) . ' ชื่อ ' . SoatDecode($data['coop_name']) . "\n";
        $update_faile =  Storage::put($fileName, $text);
        return false;
    }
}


function send_otp($msisdn)
{
    $url = "https://otp.thaibulksms.com/v2/otp/request";
    if (extension_loaded('curl')) {
        $data = array(
            'key' => '1803004557811951',
            'secret' => 'c29ea50b593a26ae6028017a33072d12',
            'msisdn' => $msisdn
        );
        $data_string = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $xml_result = curl_exec($ch);
        $code = curl_getinfo($ch);
        curl_close($ch);
    }
}


function verify_otp($token, $pin)
{
    $url = "https://otp.thaibulksms.com/v2/otp/verify";
    if (extension_loaded('curl')) {
        $data = array(
            'key' => '1803004557811951',
            'secret' => 'c29ea50b593a26ae6028017a33072d12',
            'token' => $token,
            'pin' => $pin
        );
        $data_string = http_build_query($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        $xml_result = curl_exec($ch);
        $code = curl_getinfo($ch);
        curl_close($ch);
    }
}
