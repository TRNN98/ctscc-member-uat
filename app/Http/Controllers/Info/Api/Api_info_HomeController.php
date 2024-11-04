<?php

namespace App\Http\Controllers\Info\Api;

use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Auth;

class Api_info_HomeController extends Controller
{
    //
    public function index()
    {
        $IP = f_get_ip();
        $today = date('Y-m-d H:i:s');
        $date = explode(' ', $today);
        $session_id = Session::getId();

        if (Session::get('session_id') !== $session_id) {
            $chk_sesion = DB::table('www_counter')->where('session_id', $session_id)->pluck('session_id')->first();

            if ($chk_sesion == null) {
                $insert_counter_member = DB::table('www_counter')
                    ->insert(
                        [
                            'ip_address' => $IP, 'visit_date' => $date[0], 'visit_time' => $date[1], 'session_id' => $session_id
                        ]
                    );
            }

            Session::put('session_id', $session_id);
        }
        // #########################################################################################################

        // === จำนวนคนเข้าชม === //
            $dayNow = Carbon::now()->toDateString();

            $allVisi = DB::table('www_counter')->count();
            $allVisi = (string)$allVisi;

            $todayVisi = DB::table('www_counter')->where('visit_date',$dayNow)->count();
            $todayVisi = (string)$todayVisi;

            $allVisitor = [];
            $todayVisitor = [];

            for($i = 0 ; $i < strlen($allVisi) ; $i++){
                $allVisitor[] = substr($allVisi,$i,1);
            }

            for($i = 0 ; $i < strlen($todayVisi) ; $i++){
                $todayVisitor[] = substr($todayVisi,$i,1);
            }

        // === END จำนวนคนเข้าชม === //

        //อัตราดอกเบี้ยเงินฝาก
        $deposit_rates = DB::table('www_data')->where('Category', 'deposit_rates')->first();

        //อัตราดอกเบี้ยเงินกู้
        $loan_rates = DB::table('www_data')->where('Category', 'loan_rates')->first();

        //การโอนเงิน
        $money_transfer = DB::table('www_data')->where('Category', 'money_transfer')->first();

        //สไลด์ภาพหน้าปก
        $slider_banner = www_data::where('Category', 'banner')->orderBy('DataSort', 'asc')->limit(5)->get();

        // ข่าวประชาสัมพันธ์
        $h_news_relations = www_data::where('Category', 'news_relations')->orderBy('DataSort', 'asc')->limit(3)->get();

        $h2_news_relations = www_data::where('Category', 'news_relations')->orderBy('DataSort', 'asc')->skip(3)->limit(2)->get();
        
        $news_relations = www_data::where('Category', 'news_relations')->orderBy('DataSort', 'asc')->skip(5)->limit(5)->get();
        // dump($h_news_relations);

        //ประกาศ
        // $notice = www_data::where('Category','notice')->orderBy('DataSort', 'asc')->limit(3)->get();
        
        //รายงานกิจการประจำปี
        $report_coop = www_data::where('Category', 'report_coop')->orderBy('DataSort', 'asc')->limit(3)->get();

        //รายงานการตรวจสอบบัญชี
        $audit_report = www_data::where('Category','audit_report')->orderBy('DataSort', 'asc')->limit(3)->get();

        //กระดานข่าว
        $board = DB::table('www_board')->where('show_status', 1)->orderBy('Date', 'desc')->limit(10)->get();

        // คณะกรรมการดำเนินงาน
        $committee = www_data::where('Category', 'committee_info')->orderBy('DataSort', 'asc')->get();

        // เจ้าหน้าที่
        $employee = www_data::where('Category', 'employee')->orderBy('DataSort', 'asc')->get();

        // ปฏิทินกิจกรรม block4
        $calendar = DB::table('www_data')->where('Category', 'calender')->orderBy('DataSort', 'desc')->limit(5)->get();

        //ลิ้งที่เกี่ยวข้อง block5
        $link_info = www_data::where('Category', 'link_info')->orderBy('DataSort', 'desc')->get();
        $link_crem = www_data::where('Category', 'link_crem')->orderBy('DataSort', 'desc')->get();

        //การโอนเงิน บช. ธนาคารของสหกรณ์
        $bank_acc = www_data::where('Category', 'bank_acc')->first();

        //ข่าวสารต่างๆ
        $news_activity = www_data::where('Category','news_activity')->orderBy('Date','desc')->limit(4)->get();
        $cremation_news = www_data::where('Category','cremation_news')->orderBy('Date','desc')->limit(4)->get();
        $news_purchase = www_data::where('Category','news_purchase')->orderBy('Date','desc')->limit(4)->get();
        $news_substance = www_data::where('Category','news_substance')->orderBy('Date','desc')->limit(4)->get();
        //ภาพกิจกรรม
        $pic_activity = www_data::where('Category', 'pic_activity')->orderBy('DataSort', 'asc')->limit(4)->get();

        // ระเบียบ
        $procedure = www_data::where('Category','procedure')->orderBy('Date','desc')->limit(10)->get();
        $procedure_member = www_data::where('Category','procedure_member')->orderBy('Date','desc')->limit(10)->get();
        $procedure_loan = www_data::where('Category','procedure_loan')->orderBy('Date','desc')->limit(10)->get();
        $procedure_deposit = www_data::where('Category','procedure_deposit')->orderBy('Date','desc')->limit(10)->get();
        $procedure_welfare = www_data::where('Category','procedure_welfare')->orderBy('Date','desc')->limit(10)->get();
        $procedure_work = www_data::where('Category','procedure_work')->orderBy('Date','desc')->limit(10)->get();
        //ข้อบังคับ
        $rules = DB::table('www_data')->where('Category','rules')->limit(10)->get();

        return response()->json(compact(
            'slider_banner',
            'news_coop',
            'deposit_rates',
            'loan_rates',
            'money_transfer',
            'pic_activity',
            'h_news_relations',
            'h2_news_relations',
            'news_relations',
            'report_coop',
            'link_info',
            'link_crem',
            'board',
            'employee',
            'committee',
            'scholarships',
            'calendar',
            'performance',
            'bank_acc',
            'procedure',
            'procedure_member',
            'procedure_loan',
            'procedure_deposit',
            'procedure_welfare',
            'procedure_work',
            'rules',
            'audit_report',
            'allVisitor',
            'todayVisitor',
            'news_activity',
            'pic_activity',
            'cremation_news',
            'news_purchase',
            'news_substance'
        ));
    }
}
