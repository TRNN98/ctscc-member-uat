<?php
namespace App\system;
/**
 * @package Cnv Date Time
 * @author Mr.Wittaya Yaowapong
 * @abstract This Class Using For Convert Date Time Format
 * Example : Convert Eng Date To Thai Date
 * @property today , day , month , year , date , split
 */
class Cnv_Date_Time
{
    var $today;
    var   $day;
    var $month;
    var   $year;
    var $date;
    var $split;
    function Cnv_Date_Time()
    {
        $this->date  = date('j-n-Y');
    }
    function thai_date($ag_format = 0)
    {
        $full_day = array("จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกค์", "เสาร์", "อาทิตย์");
        $full_month_th   = array('มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
        $sub_month_th  =  array('ม.ค.', 'ก.พ.', 'มี.ค', 'เม.ย.', 'พ.ค', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
        switch ($ag_format) {
            case 0:     // Full Ex. 01 มกราคม 2551
                $this->split    = explode('-', $this->date);
                $day     =  $this->split[0];
                $month =  $this->split[1];
                $year    =  $this->split[2] + 543;
                $cnv_date = $day . " " . $full_month_th[$month - 1] . " " . $year;
                return $cnv_date;
                break;

            case 1:   // Ex.  1 ม.ค. 2551
                $this->split    = explode('-', $this->date);
                $this->day     =  $this->split[0];
                $this->month =   $this->split[1];
                $this->year    = $this->split[2] + 543;
                $cnv_date = $this->day . " " . $sub_month_th[$this->month - 1] . " " . $this->year;
                return $cnv_date;
                break;
        }
    }
}


/**
 * @package    Date And Time Class
 * @author Mr.Wittaya Yaowapong
 * @abstract This Class Will Be Manage For Date Time Solution
 * Example : Convert  Eng Date  To Thai Date .
 */
class Date_Time
{
    var    $date, $month, $full_date,    $datetime, $now, $day, $split, $split_operator;

    function split_datetime()
    {
        switch ($this->split_operator) {
                /*2007-10-26 00:00:00 */
            case "-":
                $date_splited  =  explode("-", $this->datetime);
                return $date_splited;
                break;
            case " ":
                $date_splited  =  explode(" ", $this->datetime);
                return $date_splited;
                break;
        }
    }


    function get_time()
    {
        switch ($this->split_operator) {
            case "-":
                $time  =  substr($this->datetime, strlen($this->datetime) - 8);
                return $time;
                break;
            case " ":
                $time  =  substr($this->datetime, strlen($this->datetime) - 5);
                return $time;
                break;
        }
    }

    function thaidate()
    {
        if ($this->datetime == "" || $this->datetime == "0000-00-00" || $this->datetime == "0000-00-00 00:00:00") {
            return false;
        } else {
            switch ($this->split_operator) {
                case "-":
                    $date = explode("-", $this->datetime);
                    $year = $date[0] + 543;
                    if ($year == 543) {
                        $year = 0;
                    }
                    $day  = explode(" ", $date[2]);
                    return $day[0] . " " . $this->thai_month($date[1]) . " " . $year;
                    break;

                case " ":
                    $date = explode(" ", $this->datetime);
                    $year = $date[2] + 543;
                    if ($year == 543) {
                        $year = 0;
                    }
                    return $date[0] . " " . $date[1] . " " . $year;
                    break;
            }
        }
    }

    function calc_age()
    {
        switch ($this->split_operator) {
            case "-":
                $this->now            = explode(" ", date("d m Y hsu"));
                $date    =    $this->split_datetime();
                $age    =    ($this->now[2] - $date[0]);
                return $age;
            case " ":
                $this->now   = explode(" ", date("d m Y hsu"));
                $date = $this->split_datetime();
                $age = ($this->now[2] - $date[2]);
                return $age;
        }
    }

    function thai_month($ag_month = 0, $format = 'sub')
    {
        if (substr($ag_month, 0, 1) == 0) {
            $ag_month = trim($ag_month, "0");
        }
        $full_day = array("จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกค์", "เสาร์", "อาทิตย์");
        $full_month_th   = array('มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฏาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม');
        $sub_month_th  =  array('ม.ค.', 'ก.พ.', 'มี.ค', 'เม.ย.', 'พ.ค', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.');
        if ($format == 'sub') {
            return $sub_month_th[$ag_month - 1];
        } elseif ($format == 'full') {
            return $full_month_th[$ag_month - 1];
        }
    }
    function thai_year($ag_eng_year)
    {
        return  $ag_eng_year + 543;
    }
}
