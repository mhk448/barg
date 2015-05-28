<?php

/* * ********************************************
 * 	Title.........:  
 * 	File Name.....:  .class.php
 * 	Author........:  H.R.D.N
 * 	Version.......:  1.0
 * 	Last Changed..:  
 * 	Last Change...:  
 * ******************************************** */

/**
 * Persian Date Class
 * 
 * @package Parsen
 */
class PersianDate {

    function __construct() {
        //print_r(array(1=>'a','b','c'));
        //date_default_timezone_set('Asia/Tehran');
        //echo idate('H');
        // ini_get('date.timezone');
        //echo date_default_timezone_set('Asia/Tehran');
        //date_timezone_set('Asia/Teehran');
    }

    public function __destruct() {
        
    }

    /**
     * Get persian month name
     * @param integer Number of persian month (1~12)
     * @return string Persian month name
     */
    function getMonthName($month_no) {
        $month_no = (int) $month_no;
        $persian_month_names = array(1 => 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند');
        return $persian_month_names[$month_no];
    }

    /**
     * Get persian weekday name
     * @param integer Number of persian weekday (0~6)
     * @return string Persian weekday name
     */
    function getWeekDayName($week_day_no) {
        $persian_day_names = array('شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه');
        return $persian_day_names[$week_day_no];
    }

    /**
     * Get persian weekday short name
     * @param integer Number of persian weekday (0~6)
     * @return string Persian weekday short name
     */
    function getWeekDayShortName($week_day_no) {
        $persian_day_names = array('ش', 'ی', 'د', 'س', 'چ', 'پ', 'ج');
        return $persian_day_names[$week_day_no];
    }

    /**
     * Get persian month ays
     * @param integer Number of persian month (1~12)
     * @return integer Persian month days
     */
    function getMonthDays($month_no) {
        $persian_month_days = array(0, 31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        return $persian_month_days[$month_no];
    }

    /**
     * Divide two numbers
     * @param integer
     * @param integer
     * @return integer Divided number
     */
    function div($a, $b) {
        return (int) ($a / $b);
    }

    /**
     * Convert Gregorian date to Persian date
     * @param integer Gregorian year
     * @param integer Gregorian month (1~12)
     * @param integer Gregorian day (1~31)
     * @return array :
     * 					[0] Converted persian year
     * 					[1] Converted persian month
     * 					[2] Converted persian day
     */
    function gregorianToPersian($year, $month, $day) {
        $gregorian_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $jalali_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        $gregorian_year = $year - 1600;
        $gregorian_month = $month - 1;
        $gregorian_day = $day - 1;
        $gregorian_days_no = 365 * $gregorian_year + $this->div($gregorian_year + 3, 4) - $this->div($gregorian_year + 99, 100) + $this->div($gregorian_year + 399, 400);
        for ($i = 0; $i < $gregorian_month; ++$i)
            $gregorian_days_no += $gregorian_days_in_month[$i];
        if ($gregorian_month > 1 && (($gregorian_year % 4 == 0 && $gregorian_year % 100 != 0) || ($gregorian_year % 400 == 0)))
            $gregorian_days_no++;
        $gregorian_days_no += $gregorian_day;
        $jalali_days_no = $gregorian_days_no - 79;
        $jalali_leap_days = $this->div($jalali_days_no, 12053);
        $jalali_days_no = $jalali_days_no % 12053;
        $jalali_year = 979 + 33 * $jalali_leap_days + 4 * $this->div($jalali_days_no, 1461);
        $jalali_days_no %= 1461;
        if ($jalali_days_no >= 366) {
            $jalali_year += $this->div($jalali_days_no - 1, 365);
            $jalali_days_no = ($jalali_days_no - 1) % 365;
        }
        for ($i = 0; $i < 11 && $jalali_days_no >= $jalali_days_in_month[$i]; ++$i)
            $jalali_days_no -= $jalali_days_in_month[$i];
        $jalali_month = $i + 1;
        $jalali_day = $jalali_days_no + 1;
        if (strlen($jalali_month) == 1)
            $jalali_month = '0' . $jalali_month;
        if (strlen($jalali_day) == 1)
            $jalali_day = '0' . $jalali_day;
        return array($jalali_year, $jalali_month, $jalali_day);
    }

    /**
     * Convert Persian date to Gregorian date
     * @param integer Persian year
     * @param integer Persian month (1~12)
     * @param integer Persian day (1~31)
     * @return array :
     * 					[0] Converted gregorian year
     * 					[1] Converted gregorian month
     * 					[2] Converted gregorian day
     */
    function persianToGregorian($year, $month, $day) {
        $gregorian_days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
        $jalali_days_in_month = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);
        $jalali_year = $year - 979;
        $jalali_month = $month - 1;
        $jalali_day = $day - 1;
        $jalali_days_no = 365 * $jalali_year + $this->div($jalali_year, 33) * 8 + $this->div($jalali_year % 33 + 3, 4);
        for ($i = 0; $i < $jalali_month; ++$i)
            $jalali_days_no += $jalali_days_in_month[$i];
        $jalali_days_no += $jalali_day;
        $gregorian_days_no = $jalali_days_no + 79;
        $gregorian_year = 1600 + 400 * $this->div($gregorian_days_no, 146097);
        $gregorian_days_no = $gregorian_days_no % 146097;
        $leap = true;
        if ($gregorian_days_no >= 36525) {
            $gregorian_days_no--;
            $gregorian_year += 100 * $this->div($gregorian_days_no, 36524);
            $gregorian_days_no = $gregorian_days_no % 36524;
            if ($gregorian_days_no >= 365)
                $gregorian_days_no++;
            else
                $leap = false;
        }
        $gregorian_year += 4 * $this->div($gregorian_days_no, 1461);
        $gregorian_days_no %= 1461;
        if ($gregorian_days_no >= 366) {
            $leap = false;
            $gregorian_days_no--;
            $gregorian_year += $this->div($gregorian_days_no, 365);
            $gregorian_days_no = $gregorian_days_no % 365;
        }
        for ($i = 0; $gregorian_days_no >= $gregorian_days_in_month[$i] + ($i == 1 && $leap); $i++)
            $gregorian_days_no -= $gregorian_days_in_month[$i] + ($i == 1 && $leap);
        $gregorian_month = $i + 1;
        $gregorian_day = $gregorian_days_no + 1;
        if (strlen($gregorian_month) == 1)
            $gregorian_month = '0' . $gregorian_month;
        if (strlen($gregorian_day) == 1)
            $gregorian_day = '0' . $gregorian_day;
        return array($gregorian_year, $gregorian_month, $gregorian_day);
    }

    /**
     * Check persian year for leap yers
     * If given year is leap year return true, else return false
     * @param integer Persian year
     * @return boolean
     */
    function isLeapyear($year) {
        $mod = $year % 33;
        if ($mod == 1 or $mod == 5 or $mod == 9 or $mod == 13 or $mod == 17 or $mod == 22 or $mod == 26 or $mod == 30)
            return true;
        return false;
    }

    /**
     * Convert Gregorian timstamp to Persian date
     * @param integer Gregorian timestamp
     * @return array :
     * 					[0] Converted persian year
     * 					[1] Converted persian month
     * 					[2] Converted persian day
     */
    function timestampToPersian($timestapm) {
        return $this->GregorianToPersian(date("Y", $timestapm), date("n", $timestapm), date("j", $timestapm));
    }

    /**
     * Convert Gregorian timstamp to Persian date
     * @param integer Persian year
     * @param integer Persian month (1~12)
     * @param integer Persian day (1~31)
     * @return integer Timestamp of persian date
     */
    function persianToTimestamp($year, $month, $day) {
        list( $gregorian_year, $gregorian_month, $gregorian_day ) = $this->persianToGregorian($year, $month, $day);
        return strtotime($gregorian_day . "-" . $gregorian_month . "-" . $gregorian_year);
    }

    /**
     * Format persian date
     * Return formatted date string like PHP date function
     * @param string Format string like PHP date function
     * @param integer timestamp
     * @return string Formatted date string
     */
    function date($format, $timestamp = "") {
        if ($timestamp == "")
            $timestamp = time();
        list( $persian_year, $persian_month, $persian_day ) = $this->TimeStampToPersian($timestamp);
        $persian_week_day = date("w", $timestamp) + 1;
        if ($persian_week_day == 7)
            $persian_week_day = 0;
        $format_length = strlen($format);
        $i = 0;
        $result = "";
        while ($i < $format_length) {
            $parameter = $format{$i};
            if ($parameter == '\\') {
                $result .= $format{++$i};
                $i++;
                continue;
            }
            switch ($parameter) {
                //Day
                case 'd':
                    $result .= ((int) $persian_day < 10) ? "0" . (int) $persian_day : $persian_day;
                    break;
                case 'D':
                    $result .= substr($this->getWeekDayName($persian_week_day), 0, 2);
                    break;
                case 'j':
                    $result .= $persian_day;
                    break;
                case 'l':
                    $result .= $this->getWeekDayName($persian_week_day);
                    break;
                case 'N':
                    $result .= $persian_week_day + 1;
                    break;
                case 'w':
                    $result .= $persian_week_day;
                    break;
                case 'z':
                    $result .= $this->dayOfYear($persian_year, $persian_month, $persian_day);
                    break;
                //Week
                case 'W':
                    $result .= ceil($this->dayOfYear($persian_year, $persian_month, $persian_day) / 7);
                    break;
                //Month
                case 'F':
                    $result .= $this->getMonthName($persian_month);
                    break;
                case 'm':
                    $result .= ((int) $persian_month < 10) ? "0" . (int) $persian_month : $persian_month;
                    break;
                case 'M':
                    $result .= substr($this->getMonthName($persian_month), 0, 6);
                    break;
                case 'n':
                    $result .= $persian_month;
                    break;
                case 't':
                    $result .= ($this->IsLeapYear($persian_year) && $persian_month == 12) ? 30 : $this->getMonthDays($persian_month);
                    break;
                //Years
                case 'L':
                    $result .= (int) $this->IsLeapYear($persian_year);
                    break;
                case 'Y':
                case 'o':
                    $result .= $persian_year;
                    break;
                case 'y':
                    $result .= substr($persian_year, 2);
                    break;
                //Time
                case 'a':
                case 'A':
                    if (date('a', $timestamp) == 'am') {
                        $result .= ($parameter == 'a') ? 'ق.ظ' : 'قبل از ظهر';
                    } else {
                        $result .= ($parameter == 'a') ? 'ب.ظ' : 'بعد از ظهر';
                    }
                    break;
                case 'B':
                case 'g':
                case 'G':
                case 'h':
                case 'H':
                case 's':
                case 'u':
                case 'i':
                //Timezone
                case 'e':
                case 'I':
                case 'O':
                case 'P':
                case 'T':
                case 'Z':
                    $result .= date($parameter, $timestamp);
                    break;
                //Full Date/Time
                case 'c':
                    $result .= $persian_year . "-" . $persian_month . "-" . $persian_day . "T" . date("H::i:sP", $timestamp);
                    break;
                case 'r':
                    $result .= substr($this->getWeekDayName($persian_week_day), 0, 2) . "، " . $persian_day . " " . substr($this->getMonthName($persian_month), 0, 6) . " " . $persian_year . " " . date("H::i:s P", $timestamp);
                    break;
                case 'U':
                    $result .= $timestamp;
                    break;
                default:
                    $result .= $parameter;
            }
            $i++;
        }
        return $result;
    }

    function displayDate($timestamp) {
        $out = $this->date('d F Y', $timestamp);
        $out.= '<br/>';
        $out.= '<span style="font-size: 10px;">';
        $out.= $this->date('ساعت H:i:s', $timestamp);
        $out.= '</span>';
        return $out;
    }

    /**
     * Number of day in persian year
     * @param integer Persian year
     * @param integer Persian month (1~12)
     * @param integer Persian day (1~31)
     * @return integer Day of year
     */
    function dayOfYear($year, $month, $day) {
        $days = 0;
        for ($i = 1; $i < $month; $i++)
            $days += $this->getMonthDays($i);
        return $days + $day;
    }

    public function currentDate() {
        $date = $this->timestampToPersian(time());
        return $date[0] . '/' . $date[1] . '/' . $date[2];
    }

    public function timespan($seconds, $startCounterDown = FALSE, $CounterDownId = 'timespanDownCounter') {
        if (!is_numeric($seconds) OR $seconds < 0) {
            $seconds = 0;
        }
//        if (!is_numeric($time)) {
//            $time = time();
//        }
//        if ($time <= $seconds) {
//            $seconds = 0;
//        } else {
//            $seconds = $time - $seconds;
//        }
        $disp = ($CounterDownId == 'timespanDownCounter') ? '' : 'style="display:none"';
        $timespan = '<span id="real_' . $CounterDownId . '" ' . $disp . ' >';
        $years = floor($seconds / 31536000);
        if ($years > 0) {
            $span = '<span class="y">' . $years . '</span>';
            $timespan .= $span . ' ' . 'سال' . ' و ';
        }
        $seconds -= $years * 31536000;
        $months = floor($seconds / 2628000);
        if ($years > 0 OR $months > 0) {
            if ($months > 0) {
                $span = '<span class="m">' . $months . '</span>';
                $timespan .= $span . ' ' . 'ماه' . ' و ';
            }
            $seconds -= $months * 2628000;
        }
        $weeks = floor($seconds / 604800);
        if ($years > 0 OR $months > 0 OR $weeks > 0) {
            if ($weeks > 0) {
                $span = '<span class="w">' . $weeks . '</span>';
                $timespan .= $span . ' ' . 'هفته' . ' و ';
            }
            $seconds -= $weeks * 604800;
        }
        $days = floor($seconds / 86400);
        if ($months > 0 OR $weeks > 0 OR $days > 0) {
            if ($days > 0) {
                $span = '<span class="d">' . $days . '</span>';
                $timespan .= $span . ' ' . 'روز' . ' و ';
            }
            $seconds -= $days * 86400;
        }
        $hours = floor($seconds / 3600);
        if ($days > 0 OR $hours > 0) {
//            if ($hours > 0) {
            $span = '<span class="h">' . $hours . '</span>';
            $timespan .= $span . ' ' . 'ساعت' . ' و ';
//            }
            $seconds -= $hours * 3600;
        }
        $minutes = floor($seconds / 60);
        if ($days > 0 OR $hours > 0 OR $minutes > 0) {
//            if ($minutes > 0) {
            $span = '<span class="i">' . $minutes . '</span>';
            $timespan .= $span . ' ' . 'دقیقه و ';
//            }
            $seconds -= $minutes * 60;
        }
//        if ($timespan == '') {
        if (!$years AND !$months) {
            $span = '<span class="s">' . $seconds . '</span>';
            $timespan .= $span . ' ' . 'ثانیه';
        }

        $timespan.="</span>";

        $jquery = "";
        if ($startCounterDown || $CounterDownId != 'timespanDownCounter') {
            $start = $startCounterDown ? 'setInterval(downCounter_' . $CounterDownId . ', 1000);' : '';
            $jquery = '
<script type="text/javascript" >
    
    function setDownCounter_' . $CounterDownId . '(){
        var sec = $("#real_' . $CounterDownId . ' .s").html();
        $("#' . $CounterDownId . ' .s").html(sec);
            
        var min = $("#real_' . $CounterDownId . ' .i").html();
        $("#' . $CounterDownId . ' .i").html(min);
            
        var hour = $("#real_' . $CounterDownId . ' .h").html();
        $("#' . $CounterDownId . ' .h").html(hour);
        
        var day = $("#real_' . $CounterDownId . ' .d").html();
        $("#' . $CounterDownId . ' .d").html(day);
        
        var week = $("#real_' . $CounterDownId . ' .w").html();
        $("#' . $CounterDownId . ' .w").html(week);
        
        var mon = $("#real_' . $CounterDownId . ' .m").html();
        $("#' . $CounterDownId . ' .m").html(mon);
        
        var year = $("#real_' . $CounterDownId . ' .y").html();
        $("#' . $CounterDownId . ' .y").html(year);
    }
    
    function downCounter_' . $CounterDownId . '(){
        var sec = $("#' . $CounterDownId . ' .s").html();
        var min = $("#' . $CounterDownId . ' .i").html();
        var hour = $("#' . $CounterDownId . ' .h").html();
        var day = $("#' . $CounterDownId . ' .d").html();
        var week = $("#' . $CounterDownId . ' .w").html();
        var mon = $("#' . $CounterDownId . ' .m").html();
        var year = $("#' . $CounterDownId . ' .y").html();
        
        sec=(sec?sec:0);
        min=(min?min:0);
        hour=(hour?hour:0);
        day=(day?day:0);
        week=(week?week:0);
        mon=(mon?mon:0);
        year=(year?year:0);
        
        (sec<0)?(sec=59,min--):(sec--);
        (min<0)?(min=59,hour--):"";
        (hour<0)?(hour=23,day--):"";
        (day<0)?(day=6,week--):"";
        /*(week<=0)?(week=3,mon--):"";
        (mon<=0)?(mon=11,year--):"";*/
        
        $("#' . $CounterDownId . ' .s").html(sec);
        $("#' . $CounterDownId . ' .i").html(min);
        $("#' . $CounterDownId . ' .h").html(hour);
        $("#' . $CounterDownId . ' .d").html(day);
        $("#' . $CounterDownId . ' .w").html(week);
        $("#' . $CounterDownId . ' .m").html(mon);
        $("#' . $CounterDownId . ' .y").html(year);
        
    }
    setDownCounter_' . $CounterDownId . '();
    ' . $start . '
</script>
';
        }
        return $timespan . $jquery;
    }

    function counterDown($id, $until, $expire_id = '') {
        echo '<span id="cd_' . $id . '"></span>';
        echo '<script type="text/javascript" >mhkCounterDown("#cd_' . $id . '",' . $until . ',"","' . $expire_id . '");</script>';
    }
    
     function displayDateAgo($timestamp) {
        return '<span class="timeago" title="' . date(DATE_ISO8601, $timestamp) . '"></span>';
    }
    
}