<?php

namespace App\Http\Controllers\Member\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\admin\www_data;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Mpdf\Mpdf;

class Api_mem_keep_detController extends Controller
{

    // Webmember keeping
    public function member_kep()
    {
        $membership_no = Auth::user()->membership_no;

        $datakeepdet = DB::select("SELECT
                                        sm_kep_t_monthly_receive.receive_month,
                                        sm_kep_t_monthly_receive.receive_year,
                                        sm_kep_t_monthly_receive.seq_no,
                                        sm_kep_t_monthly_receive.receipt_no,
                                        sm_kep_t_monthly_receive.receipt_date,
                                        sm_kep_t_monthly_receive.receipt_status,
                                        sm_kep_t_monthly_receive.kep_method_amount,
                                        sm_kep_t_monthly_receive.posted_run,
                                        CONCAT(FP_GET_MONTH_SHOT(receive_month),
                                                '<br>',
                                                SUBSTR(receive_year + 543, 3, 2)) AS receive_month_fp,
                                        (	SELECT
                                                COUNT(1)
                                            FROM
                                                sm_kep_t_monthly_receive_det
                                            WHERE
                                                sm_kep_t_monthly_receive.MEMBERSHIP_NO = sm_kep_t_monthly_receive_det.MEMBERSHIP_NO
                                            and sm_kep_t_monthly_receive.RECEIVE_MONTH = sm_kep_t_monthly_receive_det.RECEIVE_MONTH
                                            and sm_kep_t_monthly_receive.RECEIVE_YEAR  = sm_kep_t_monthly_receive_det.RECEIVE_YEAR
                                           and sm_kep_t_monthly_receive.seq_no  = sm_kep_t_monthly_receive_det.seq_no
                                           ) AS count_seqno ,
                                        (
                                            SELECT
                                            SUM(MONEY_AMOUNT_NOT)
                                            FROM
                                            sm_kep_t_monthly_receive_det
                                            WHERE
                                            sm_kep_t_monthly_receive.MEMBERSHIP_NO = sm_kep_t_monthly_receive_det.MEMBERSHIP_NO
                                            AND sm_kep_t_monthly_receive.RECEIVE_MONTH = sm_kep_t_monthly_receive_det.RECEIVE_MONTH
                                            AND sm_kep_t_monthly_receive.RECEIVE_YEAR  = sm_kep_t_monthly_receive_det.RECEIVE_YEAR
                                        ) AS mproc_money_amount
                                    FROM
                                        sm_kep_t_monthly_receive
                                    WHERE
                                        membership_no = :membership_no
                                            -- AND (sm_kep_t_monthly_receive.receipt_status = '0' OR sm_kep_t_monthly_receive.receipt_status = 'E')
                                    HAVING count_seqno > 0

                                    ORDER BY receive_year desc, receive_month DESC

                                    -- LIMIT 0 , 5
                                    ", ['membership_no' => $membership_no]);


        $datadetail = [];

        foreach ($datakeepdet as $index => $rowdetail) {

            $datadetail[$index] = DB::select(
                "SELECT
                sm_kep_t_monthly_receive.receipt_date AS receipt_date,
                sm_kep_t_monthly_receive.receipt_no AS receipt_no,
                sm_kep_t_monthly_receive_det.keeping_type_code,
                sm_kep_t_monthly_receive_det.receive_description,
                sm_kep_t_monthly_receive_det.period,
                COALESCE (
                  sm_kep_t_monthly_receive_det.principal_not,
                  sm_kep_t_monthly_receive_det.principal_balance_of_loan,
                  sm_kep_t_monthly_receive_det.principal_not
                ) AS mproc_principal_of_loan,
                sm_kep_t_monthly_receive_det.INTEREST_NOT mproc_interest,
                sm_kep_t_monthly_receive_det.MONEY_AMOUNT_NOT mproc_money_amount,
                sm_kep_t_monthly_receive_det.receive_month,
                sm_kep_t_monthly_receive.total_share_value,
                sm_kep_t_monthly_receive_det.KEEPING_TYPE_NAME
              FROM
                sm_kep_t_monthly_receive,
                sm_kep_t_monthly_receive_det
              WHERE (
                  sm_kep_t_monthly_receive.receive_month = sm_kep_t_monthly_receive_det.receive_month
                )
                AND (
                  sm_kep_t_monthly_receive.receive_year = sm_kep_t_monthly_receive_det.receive_year
                )
                AND (
                  sm_kep_t_monthly_receive.membership_no = sm_kep_t_monthly_receive_det.membership_no
                )
                AND (
                  sm_kep_t_monthly_receive.seq_no = sm_kep_t_monthly_receive_det.seq_no
                )
                AND (
                  sm_kep_t_monthly_receive.membership_no = :membership_no
                )
                AND (
                  sm_kep_t_monthly_receive.receive_month = :receive_month
                )
                AND (
                  sm_kep_t_monthly_receive.receive_year = :receive_year
                )
              ORDER BY keeping_type_code DESC",
                [
                    'membership_no' => $membership_no, 'receive_month' => $rowdetail->receive_month, 'receive_year' => $rowdetail->receive_year
                ]
            );
        }

        return response()->json(compact('datakeepdet', 'datadetail'));
    }

    public function kepPrint(Request $request, $receive_year, $receive_month, $seq_no, $token)
    {
        // dd($receive_year, $receive_month, $seq_no, $token);
        $request->headers->set('Authorization', 'Bearer ' . $token);

        $proxy = Request::create("/api/v1/member/print_pdf/$receive_year/$receive_month", 'GET');

        return Route::dispatch($proxy);
    }

    public function member_PrintKep($receive_year, $receive_month)
    {
        $html = '';
        $membership_no = Auth::user()->membership_no;
        $result = DB::select("SELECT
                                    kep.receipt_no,
                                    kep.membership_no,
                                    CONCAT(DAY(kep.receipt_date),
                                            '/',
                                            MONTH(kep.receipt_date),
                                            '/',
                                            YEAR(kep.receipt_date) + 543) receipt_date,
                                    kep.total_share_value,
                                    kep.total_interest_value,
                                    CONCAT(mem_regis.prename,
                                            mem_regis.member_name,
                                            '   ',
                                            mem_regis.member_surname) AS member_name,
                                    mem_regis.member_group_no,
                                    mem_regis.salary_id,
                                    kep.seq_no,
                                    mem_regis.member_group_name,
                                    mem_regis.total_loan_int,
                                    kep.receive_year,
                                    kep.receive_month,
                                    kep.posted_run
                                    ,mem_regis.salary_amount
                                FROM
                                    sm_mem_m_membership_registered mem_regis
                                INNER JOIN
                                    sm_kep_t_monthly_receive kep ON mem_regis.membership_no = kep.membership_no
                                WHERE   -- (kep.receipt_no IS NOT NULL)
                                    (kep.membership_no='" . $membership_no . "')
                                    AND kep.receive_year = '" . $receive_year . "'
                                    AND kep.receive_month = '" . $receive_month . "'");

        $gmonth = convert_full_month($result[0]->receive_month);
        $gyear = $result[0]->receive_year + 543;

        $cutday = explode('/', $result[0]->receipt_date);
        $dayNow = $cutday[0];
        $monthNow = convert_full_month((int) $cutday[1]);
        $yearNow = (int) $cutday[2];
        $setDate = $dayNow . " " . $monthNow . " " . $yearNow;
        $postedRun = $result[0]->posted_run;
        if ($postedRun == '0') {
            $head_print     =   "ใบแจ้งหนี้";
            $footer_print   =   '
            <table border="" width="100%">
                <tr>
                    <td colspan="5" align="center"><br/><br/>
                        <small>ใบแจ้งหนี้ไมใช่ใบเสร็จรับเงิน เนื่องจากสหกรณ์ยังไม่ได้รับเงิน</small>
                    </td>
                </tr>
            </table>
            ';
        } else {
            $head_print     =   "ใบเสร็จรับเงิน";
            $signature = www_data::where('Category', 'signature')->orderBy('No', 'asc')->get();

            // dd($signature[0]->nphoto);

            if ($signature[0]->nphoto) {
                $imgSig1 = '<img src="' . public_path("mediafiles/picture/" . $signature[0]->nphoto) . '" alt="" width="90" />';
            }

            if ($signature[1]->nphoto) {
                $imgSig2 = '<img src="' . public_path("mediafiles/picture/" . $signature[1]->nphoto) . '" alt="" width="90" />';
            }

            $footer_print   =   '
                <table border="" width="100%">
                    <tr>
                        <td width="10%"></td>
                        <td width="25%" align="center" class="botb-d">' . $imgSig1 . '</td>
                        <td width="10%" align="left" valign="bottom">' . $signature[0]->Question . '</td>
                        <td width="25%" align="center" class="botb-d">' . $imgSig2 . '</td>
                        <td width="25%" align="left" valign="bottom">' . $signature[1]->Question . '</td>
                    </tr>
                    <tr>
                        <td width=""></td>
                        <td width="35%" align="center" valign="bottom">' . $signature[0]->Note . '</td>
                        <td width=""></td>
                        <td width="35%" align="center" valign="bottom">' . $signature[1]->Note . '</td>
                    </tr>
                    <tr>
                        <td colspan="5" align="center"><br/><br/>
                            <small>หมายเหตุ : ใบเสร็จฉบับนี้จะสมบูรณ์ก็ต่อเมื่อสหกรณ์ออมทรัพย์ครูชุมพร จำกัด ได้รับการชำระเงินเรียบร้อยแล้ว</small>
                        </td>
                    </tr>
                </table>
                ';
        }

        $strsql = DB::select(
            "SELECT
                                sm_kep_t_monthly_receive.receipt_date,
                                sm_kep_t_monthly_receive.receipt_no,
                                sm_kep_t_monthly_receive_det.keeping_type_code,
                                sm_kep_t_monthly_receive_det.keeping_type_group,
                                sm_kep_t_monthly_receive_det.keeping_type_name,
                                sm_kep_t_monthly_receive_det.receive_description,
                                sm_kep_t_monthly_receive_det.period,
                                COALESCE (
                                sm_kep_t_monthly_receive_det.principal_not,
                                sm_kep_t_monthly_receive_det.principal_balance_of_loan,
                                sm_kep_t_monthly_receive_det.principal_not
                                ) AS mproc_principal_of_loan,
                                sm_kep_t_monthly_receive_det.interest_not interest,
                                (sm_kep_t_monthly_receive_det.money_amount_not) money_amount,
                                sm_kep_t_monthly_receive_det.principal_balance_of_loan,
                                sm_kep_t_monthly_receive_det.mpost_principal_balance,
                                sm_kep_t_monthly_receive_det.posting_status,
                                sm_kep_t_monthly_receive_det.receive_month,
                                sm_kep_t_monthly_receive.total_share_value
                            FROM
                                sm_kep_t_monthly_receive,
                                sm_kep_t_monthly_receive_det
                            WHERE (
                                sm_kep_t_monthly_receive.receive_month = sm_kep_t_monthly_receive_det.receive_month
                                )
                                AND (
                                sm_kep_t_monthly_receive.receive_year = sm_kep_t_monthly_receive_det.receive_year
                                )
                                AND (
                                sm_kep_t_monthly_receive.membership_no = sm_kep_t_monthly_receive_det.membership_no
                                )
                                AND (
                                sm_kep_t_monthly_receive.seq_no = sm_kep_t_monthly_receive_det.seq_no
                                )
                                AND (
                                sm_kep_t_monthly_receive.membership_no = :membership_no
                                )
                                AND (
                                sm_kep_t_monthly_receive.receive_month = :receive_month
                                )
                                AND (
                                sm_kep_t_monthly_receive.receive_year = :receive_year
                                )
                                -- AND (
                                --     sm_kep_t_monthly_receive.receipt_status = '0'  or   sm_kep_t_monthly_receive.receipt_status = 'E'
                                -- )
                            ORDER BY sm_kep_t_monthly_receive_det.keeping_type_code desc,receive_description asc",
            [
                'membership_no' => $membership_no, 'receive_month' => $receive_month, 'receive_year' => $receive_year
            ]
        );

        // }

        // $p_des    = DB::select("SELECT * FROM www_data
        //                         WHERE category = 'print_des'
        //                         ORDER BY No ASC LIMIT 0,1");

        // dd($result,$strsql);

        $sumMoneyAmount = 0;

        foreach ($strsql as $i) {

            $sumMoneyAmount += $i->money_amount;
        }

        $salary_kep_af = $result[0]->salary_amount - $sumMoneyAmount;

        $html .=
            '
            <style>
                .table3{
                    border-collapse: collapse;
                    border-radius:1em !important;
                    overflow: hidden;
                }
                .table3 td{
                    padding:5px 10px 10px 10px;
                    font-size:12px;
                }
                .table3 th{
                padding:8px;
                }
                .table3 th{
                    border-bottom:1px solid #757880;
                    font-size:12px;
                }
                .tbfoot td{
                    padding:10px;
                    font-size:12px;
                    border-top:1px solid #757880;
                }
                .topb{
                    border-top:1px solid #757880;
                }
                .lefb{
                    border-left:1px solid #757880;
                }
                .rigb{
                    border-right:1px solid #757880;
                }
                .botb{
                    border-bottom:1px solid #757880;
                }
                .botb-d{
                    border-bottom:2px dotted #757880;
                }.water{
                    position: absolute;
                }
                .waterbg{
                    background-image:url("/member/images/logo.png") ;
                    background-repeat: no-repeat;
                    background-position:center center;
                    background-size: contain;
                    width:50%;
                    height:600px;
                    position:absolute;
                    left:25%;
                    top:5%;
                    transform: translate(-25%,-5%);
                }
                #tbhead tr td{
                    padding:8px;
                    font-size:12px;
                }
                .A4footer{
                    position:relative;
                    padding-left:40px;
                    width:600px;
                    margin-top:0px;
                }
                .hide{
                    display:none;
                }
            </style>
                <div style="border:3px solid #595959; width:750px; height:auto; border-radius:5px; padding:15px;">

                        <div style="border: 1px solid #595959;border-radius:5px;padding:15px;margin-bottom:15px;">
                            <table border="0" width="100%">
                                <tr>
                                    <td colspan="3" align="center" width="100%"><b>' . $head_print . '</b></td>
                                </tr>
                                <tr>
                                    <td colspan="3" align="center">
                                        <b>สหกรณ์ออมทรัพย์ครูชุมพร จำกัด</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%" rowspan="2" align="center">
                                        <img src="info/assets/index/logo.jpg" height="150" alt="">
                                    </td>
                                    <td align="right" style="padding-top:10px;" colspan="2">
                                        <br>
                                        <br>
                                        <b>วันที่ &nbsp;</b>' . $setDate . '
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                </tr>
                            </table>
                            <table id="tbhead" border="0" width="100%" style="margin-top:5px;">
                                <tr>
                                    <td colspan="2"></td>
                                    <td colspan="2" align="right"></td>
                                </tr>
                                <tr>
                                    <td width="55%"><b>ได้รับเงินจาก :</b>&nbsp;&nbsp;&nbsp;' . $result[0]->member_name . '</td>
                                    <td width="0%"></td>
                                    <td width="10%"></td>
                                    <td width="35%" align="left"><b>ใบเสร็จเลขที่ : </b>' . $result[0]->receipt_no . '</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>หน่วยงาน/สังกัด :</b>&nbsp;&nbsp;&nbsp;' . $result[0]->member_group_no . '&nbsp;:&nbsp;' . $result[0]->member_group_name . '</td>
                                    <td></td>
                                    <td align="left">
                                        <b>เลขที่สมาชิก : </b>' . $result[0]->membership_no . '
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>ทุนเรือนหุ้น :</b>&nbsp;&nbsp;&nbsp;' . number_format($result[0]->total_share_value, 2) . '</td>
                                    <td></td>
                                    <td align="left">
                                        <b>ดอกเบี้ยสะสม : </b>' . number_format($result[0]->total_interest_value, 2) . '&nbsp;&nbsp;บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><b>เงินเดือน :</b>&nbsp;&nbsp;&nbsp;' . number_format($result[0]->salary_amount, 2) . '</td>
                                    <td></td>
                                    <td align="left">
                                        <b>เงินเดือนคงเหลือ : </b> ' . number_format($salary_kep_af, 2) . '&nbsp;&nbsp;บาท
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <b>ยอดเรียกเก็บร้อยละ : </b> ' . number_format((($sumMoneyAmount * 100) / $result[0]->salary_amount), 2) . ' ของเงินเดือน
                                    </td>
                                    <td></td>
                                    <td align="left">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="border: 1px solid #595959;border-radius:12px;margin-bottom:10px;">
                            <table width="100%" class="table3" border="0">
                                <tr>
                                    <th width="37%" class="rigb">รายการชำระ</th>
                                    <th width="10%" class="rigb">งวดที่</th>
                                    <th width="13%" class="rigb">เงินต้น</th>
                                    <th width="15%" class="rigb">ดอกเบี้ย</th>
                                    <th width="15%" class="rigb">จำนวนเงิน</th>
                                    <th width="15%">คงเหลือ</th>
                                </tr> ';

        $sum_money_amount = 0;
        // $sum_principal_balance_of_loan = 0;
        // $sum_principal_of_loan = 0;
        // $sum_interest = 0;
        foreach ($strsql as $kep_det) {
            $sum_money_amount += $kep_det->money_amount;

            // $sum_principal_balance_of_loan   += $kep_det->principal_balance_of_loan;
            // $sum_principal_of_loan  += $kep_det->principal_of_loan;
            // $sum_interest  += $kep_det->interest;

            if (number_format($kep_det->mproc_principal_of_loan, 2) == '0.00') {
                $pl = '-';
            } else {
                $pl = number_format($kep_det->mproc_principal_of_loan, 2);
            }

            if (number_format($kep_det->interest, 2) == '0.00') {
                $int = '-';
            } else {
                $int = number_format($kep_det->interest, 2);
            }

            if ($kep_det->period == 0) {
                $period = "-";
            } else {
                $period = $kep_det->period;
            }

            if (number_format($kep_det->money_amount, 2) == '0.00') {
                $money_amount = "-";
            } else {
                $money_amount = number_format($kep_det->money_amount, 2);
            }

            // if ($kep_det->keeping_type_group == 'SHR') {

            // if (number_format($kep_det->principal_balance_of_loan, 2) == '0.00') {
            //     $principal_balance = "-";
            // } else {
            //     $principal_balance = number_format($kep_det->principal_balance_of_loan, 2);
            // }

            // } else {
            if (number_format($kep_det->mpost_principal_balance, 2) == '0.00') {
                $principal_balance = "-";
            } else {
                $principal_balance = number_format($kep_det->mpost_principal_balance, 2);
            }
            // }


            $html .= "<tr>
                                            <td align='left' class=' rigb' >" . $kep_det->keeping_type_name . "&nbsp;" . $kep_det->receive_description . "</td>
                                            <td align='center' class=' rigb' >" . $period . "</td>
                                            <td align='right' class=' rigb' >" . $pl . "</td>
                                            <td align='right' class=' rigb' >" . $int . "</td>
                                            <td align='right' class=' rigb' >" . $money_amount . "</td>
                                            <td align='right' class='' >" . $principal_balance . "</td>
                                        </tr>";
        } //end loop while

        // if ($postedRun == '0') {
        //     $html .=            '<tr class="tbfoot">
        //                             <td class="rigb" colspan="3"><b></b></td>
        //                             <td align="right"><b>รวมเงิน</b></td>
        //                             <td colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        //                         </tr>

        //                     </table>

        //                 </div>
        //                 <br/>

        //                 <hr>
        //         </div>
        //     ';
        // } else {

        $real_sum = $sum_money_amount == 0 ? 'ศูนย์บาทถ้วน' : CvnEngToThaiMoney($sum_money_amount);

        $html .=            '<tr class="tbfoot">
                                    <td class="rigb" colspan="3" align="center"><b> - ' . $real_sum . ' -</b></td>
                                    <td align="right"><b>รวมเงิน</b></td>
                                    <td align="right">' . number_format($sum_money_amount, 2) . '</td>
                                    <td></td>
                                </tr>

                            </table>
                    </div>
                    <br/>
                    ' . $footer_print . '
                    <br>
                    <hr>

            </div>';
        // }


        //     <div style="width:750;  height:400px;line-height:17px; padding-top:-15px; ">
        //     '.$p_des[0]->Note.'
        // </div>
        // ('utf-8','A4','14','Garuda',10,10,10,5,10,10);
        $constructor = [
            'mode' => 'utf-8',
            'format' => 'A4',
            'default_font_size' => 0,
            'default_font' => 'garuda',
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 8,
            'margin_bottom' => 5,
            'margin_header' => 10,
            'margin_footer' => 10,
            'orientation' => 'P',
            'tempDir'  => base_path('storage/app/mpdf'),
        ];
        // 'utf-8','A4','14','garuda',10,10,5,5,10,10

        $mpdf = new mPDF($constructor);
        $mpdf->SetAuthor("SSBD@SO-AT SOLUTION COMPANY LIMITED");
        $mpdf->SetTitle($head_print);
        $mpdf->SetWatermarkImage("member/images/logo.png", 0.2, array(110, 100), array(50, 80));
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        // $mpdf->Output();
        // echo $html;
        // dd($mpdf->Output("kept" . date('Ymd') . ".pdf", 'S'));

        // return $mpdf->Output("kept" . date('Ymd') . ".pdf", 'S');

        if (Auth::guard('mobile-api')->check()) {
            return $mpdf->Output("kept" . date('Ymd') . ".pdf", 'S');
        } else {
            $mpdf->Output("kept" . date('Ymd') . ".pdf", 'I');
        }
    }
}
