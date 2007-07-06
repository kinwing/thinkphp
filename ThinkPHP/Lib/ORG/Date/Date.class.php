<?php 
// +----------------------------------------------------------------------+
// | ThinkPHP                                                             |
// +----------------------------------------------------------------------+
// | Copyright (c) 2006 liu21st.com All rights reserved.                  |
// +----------------------------------------------------------------------+
// | Licensed under the Apache License, Version 2.0 (the 'License');      |
// | you may not use this file except in compliance with the License.     |
// | You may obtain a copy of the License at                              |
// | http://www.apache.org/licenses/LICENSE-2.0                           |
// | Unless required by applicable law or agreed to in writing, software  |
// | distributed under the License is distributed on an 'AS IS' BASIS,    |
// | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or      |
// | implied. See the License for the specific language governing         |
// | permissions and limitations under the License.                       |
// +----------------------------------------------------------------------+
// | Author: liu21st <liu21st@gmail.com>                                  |
// +----------------------------------------------------------------------+
// $Id: Date.class.php 11 2007-01-04 03:57:34Z liu21st $


/**
 +------------------------------------------------------------------------------
 * 日期时间操作类
 +------------------------------------------------------------------------------
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id: Date.class.php 11 2007-01-04 03:57:34Z liu21st $
 +------------------------------------------------------------------------------
 */
class Date extends Base
{//类定义开始

    /**
     +----------------------------------------------------------
     * 日期的时间戳
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $date;      

    /**
     +----------------------------------------------------------
     * 时区
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $timezone;      


    /**
     +----------------------------------------------------------
     * 年
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $year;      

    /**
     +----------------------------------------------------------
     * 月
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $month;      

    /**
     +----------------------------------------------------------
     * 日
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $day;      

    /**
     +----------------------------------------------------------
     * 时
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $hour;      

    /**
     +----------------------------------------------------------
     * 分
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $minute;      

    /**
     +----------------------------------------------------------
     * 秒
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $second;      

    /**
     +----------------------------------------------------------
     * 星期的数字表示
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $weekday;      

    /**
     +----------------------------------------------------------
     * 星期的完整表示
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
     var $cWeekday;      

    /**
     +----------------------------------------------------------
     * 一年中的天数 0－365
     +----------------------------------------------------------
     * @var integer
     * @access protected
     +----------------------------------------------------------
     */
     var $yDay;      

    /**
     +----------------------------------------------------------
     * 月份的完整表示
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
     var $cMonth;      

    /**
     +----------------------------------------------------------
     * 日期CDATE表示
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
     var $CDATE;      

    /**
     +----------------------------------------------------------
     * 日期的YMD表示
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
     var $YMD;      

    /**
     +----------------------------------------------------------
     * 时间的输出表示 
     +----------------------------------------------------------
     * @var string
     * @access protected
     +----------------------------------------------------------
     */
     var $CTIME;      
    var $Week = array("日","一","二","三","四","五","六");
    /**
     +----------------------------------------------------------
     * 架构函数
     * 创建一个Date对象
     +----------------------------------------------------------
     * @param mixed $date  日期
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     */
    function __construct($date='')
    {
        //分析日期
        $this->date =   $this->parse($date);
        $this->setDate($this->date);
    }
    
    /**
     +----------------------------------------------------------
     * 日期分析 
     * 返回时间戳
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param mixed $date 日期
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function parse($date) 
    {
        if (is_string($date)) {
			
            if (($date == "") || strtotime($date) == -1) {
                //为空默认取得当前时间戳
                $tmpdate = time();
            } else {
                //把字符串转换成UNIX时间戳
                $tmpdate = strtotime($date);
            }

        } elseif (is_null($date))  {
            //为空默认取得当前时间戳
            $tmpdate = time();

        } elseif (is_numeric($date)) {
            //数字格式直接转换为时间戳
            $tmpdate = $date;

        } else {
            if (get_class($date) == "date") {
                //如果是Date对象
                $tmpdate = $date->date;
            } else {
                //默认取当前时间戳
                $tmpdate = time();
            }
        }

        return $tmpdate;
    }

    /**
     +----------------------------------------------------------
     * 验证日期数据是否有效
     * 
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @param mixed $date 日期数据
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function valid($date) 
    {
        
    }


    /**
     +----------------------------------------------------------
     * 日期参数设置
     * 
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param integer $date  日期时间戳
     +----------------------------------------------------------
     * @return void
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function setDate($date) 
    {
        $dateArray  =   getdate($date);
        $this->date         =   $dateArray[0];            //时间戳
        $this->second       =   $dateArray["seconds"];    //秒
        $this->minute       =   $dateArray["minutes"];    //分
        $this->hour         =   $dateArray["hours"];      //时
        $this->day          =   $dateArray["mday"];       //日
        $this->month        =   $dateArray["mon"];        //月
        $this->year         =   $dateArray["year"];       //年

        $this->weekday      =   $dateArray["wday"];       //星期 0～6
        $this->cWeekday     =   '星期'.$this->Week[$this->weekday];//$dateArray["weekday"];    //星期完整表示
        $this->yDay         =   $dateArray["yday"];       //一年中的天数 0－365
        $this->cMonth       =   $dateArray["month"];      //月份的完整表示

        $this->CDATE        =   $this->format("%Y-%m-%d");//日期表示
        $this->YMD          =   $this->format("%Y%m%d");  //简单日期
        $this->CTIME        =   $this->format("%H:%M:%S");//时间表示    

        return ;
    }

    /**
     +----------------------------------------------------------
     * 日期格式化
     * 默认返回 1970-01-01 11:30:45 格式
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @param string $format  格式化参数
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function format($format = "%Y-%m-%d %H:%M:%S") {
        return strftime($format, $this->date);
    }

    /**
     +----------------------------------------------------------
     * 是否为闰年
     * 
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function isLeapYear() 
    {
        return (($this->year % 4) == 0);
    }

    /**
     +----------------------------------------------------------
     * 计算日期差
     * 
     *  w - weeks
     *  d - days
     *  h - hours
     *  m - minutes
     *  s - seconds
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param mixed $date 要比较的日期
     * @param string $elaps  比较跨度
     +----------------------------------------------------------
     * @return integer
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function dateDiff($date, $elaps = "d") 
    {
        $__DAYS_PER_WEEK__       = (7);
        $__HOURS_IN_A_DAY__      = (24);
        $__MINUTES_IN_A_DAY__    = (1440);
        $__SECONDS_IN_A_DAY__    = (86400);

        //计算天数差
        $__DAYSELAPS = ($this->parse($date) - $this->date) / $__SECONDS_IN_A_DAY__ ;

        switch ($elaps) {
            case "w"://转换成星期
                $__DAYSELAPS =  $__DAYSELAPS / $__DAYS_PER_WEEK__;
                break;
            case "h"://转换成小时
                $__DAYSELAPS =  $__DAYSELAPS * $__HOURS_IN_A_DAY__;
                break;        
            case "m"://转换成分钟
                $__DAYSELAPS =  $__DAYSELAPS * $__MINUTES_IN_A_DAY__;  
                break;
            case "s"://转换成秒
                $__DAYSELAPS =  $__DAYSELAPS * $__SECONDS_IN_A_DAY__;
                break;        
        } 

        return $__DAYSELAPS;

    }

    /**
     +----------------------------------------------------------
     * 人性化的计算日期差
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param mixed $time 要比较的时间
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function timeDiff( $time ) {     
        $diff = (int) abs($this->date - $time);
        if ($diff <= 3600) {
            $mins = round($diff / 60);
            if ($mins <= 1)
                $since = '1 分钟';
            else
                $since = sprintf( '%s 分钟', $mins);
        } else if (($diff <= 86400) && ($diff > 3600)) {
            $hours = round($diff / 3600);
            if ($hours <= 1)
                $since = '1 小时';
            else 
                $since = sprintf( '%s 小时', $hours );
        } elseif ($diff >= 86400) {
            $days = round($diff / 86400);
            if ($days <= 1)
                $since = '1 天';
            else
                $since = sprintf( '%s 天', $days );
        }
        return $since;
    }

    /**
     +----------------------------------------------------------
     * 计算月份的第一天
     * 返回Date对象
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function firstDayOfMonth() {
        return (new Date(strftime("%Y-%m-%d", mktime(0, 0, 0,
                               $this->month,           
                               1, 
                               $this->year ))));           
    }

    /**
     +----------------------------------------------------------
     * 计算年份的第一天
     * 返回Date对象
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function firstDayOfYear() {
        return (new Date(strftime("%Y-%m-%d", mktime(0, 0, 0,
                               1,
                               1,
                               $this->year))));           
    } 

    /**
     +----------------------------------------------------------
     * 计算月份的最后一天
     * 返回Date对象
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function lastDayOfMonth() {
        return (new Date(strftime("%Y-%m-%d", mktime(0, 0, 0,
                               $this->month + 1,    
                               0,                   
                               $this->year ))));     
    }

    /**
     +----------------------------------------------------------
     * 计算年份的最后一天
     * 返回Date对象
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function lastDayOfYear() {
        return (new Date(strftime("%Y-%m-%d", mktime(0, 0, 0,
                               1,                   
                               0,                   
                               $this->year + 1)))); 
    }

    /**
     +----------------------------------------------------------
     * 计算月份的最大天数
     * 
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @return integer
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function maxDayOfMonth() 
    {
        $result = $this->dateDiff($this->dateAdd(1,'m'),'d');
        return $result;    	
    }

    /**
     +----------------------------------------------------------
     * 取得指定间隔日期
     * 
     *    yyyy - 年
     *    q    - 季度
     *    m    - 月
     *    y    - day of year
     *    d    - 日
     *    w    - 周
     *    ww   - week of year
     *    h    - 小时
     *    n    - 分钟
     *    s    - 秒
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @param integer $number 间隔数目
     * @param string $interval  比较类型
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function dateAdd($number = 0, $interval = "d") 
    {
        $hours =  $this->hour;
        $minutes =  $this->minute;
        $seconds =  $this->second;
        $month =  $this->month;
        $day =  $this->day;
        $year =  $this->year;

        switch ($interval)
        {
            case "yyyy":
                //---Add $number to year
                $year += $number;
                break;

            case "q":
                //---Add $number to quarter
                $year += ($number*3);
                break;

            case "m":
                //---Add $number to month
                $month += $number;
                break;

            case "y":
            case "d":
            case "w":
                //---Add $number to day of year, day, day of week
                $day += $number;
                break;

            case "ww":
                //---Add $number to week
                $day += ($number*7);
                break;

            case "h":
                //---Add $number to hours
                $hours += $number;
                break;

            case "n":
                //---Add $number to minutes
                $minutes += $number;
                break;

            case "s":
                //---Add $number to seconds
                $seconds += $number;
                break;        
        } 

        return (new Date(mktime($hours,
                                $minutes,
                                $seconds,
                                $month,
                                $day,
                                $year)));

    }

    /**
     +----------------------------------------------------------
     * 日期数字转中文
     * 用于日和月、周
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param integer $number 日期数字
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function  numberToCh($number)
    {  
        $number = intval($number);
        $array  = array('一','二','三','四','五','六','七','八','九','十');  
        $str = '';
        if($number  ==0)  { $str .= "十" ;}  
        if($number  <  10){  
           $str .= $array[$number-1] ;
        }  
        elseif($number  <  20  ){  
           $str .= "十".$array[$number-11];
        }  
        elseif($number  <  30  ){  
           $str .= "二十".$array[$number-21];
        }  
        else{  
           $str .= "三十".$array[$number-31];
        }  
        return $str;
    } 


    /**
     +----------------------------------------------------------
     * 年份数字转中文
     * 
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param integer $yearStr 年份数字
     * @param boolean $flag 是否显示公元
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */   
    function  yearToCh( $yearStr ,$flag=false ){  
        $array = array('零','一','二','三','四','五','六','七','八','九');  
        $str = $flag? '公元' : '';
        for($i=0;$i<4;$i++){  
            $str .= $array[substr($yearStr,$i,1)];
        }  
        return $str;
    }

    /**
     +----------------------------------------------------------
     * 	判断日期 所属 干支 生肖 星座
     *  type 参数：XZ 星座 GZ 干支 SX 生肖
     * 
     +----------------------------------------------------------
     * @static
     * @access public 
     +----------------------------------------------------------
     * @param string $type  获取信息类型
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     * @throws FcsException
     +----------------------------------------------------------
     */
    function magicInfo($type) 
    {
        $result = '';
        $m      =   $this->month;
        $y      =   $this->year;
        $d      =   $this->day;

        switch ($type)
        {
        case 'XZ'://星座
            $XZDict = array('摩羯','宝瓶','双鱼','白羊','金牛','双子','巨蟹','狮子','处女','天秤','天蝎','射手');
            $Zone   = array(1222,122,222,321,421,522,622,722,822,922,1022,1122,1222);
            if((100*$m+$d)>=$Zone[0]||(100*$m+$d)<$Zone[1])
                $i=0;
            else
                for($i=1;$i<12;$i++){
                if((100*$m+$d)>=$Zone[$i]&&(100*$m+$d)<$Zone[$i+1])
                  break;
                }
            $result = $XZDict[$i].'座';
            break;

        case 'GZ'://干支
            $GZDict = array(
                        array('甲','乙','丙','丁','戊','己','庚','辛','壬','癸'),
                        array('子','丑','寅','卯','辰','巳','午','未','申','酉','戌','亥')
                        );
            $i= $y -1900+36 ;
            $result = $GZDict[0][$i%10].$GZDict[1][$i%12];
            break;

        case 'SX'://生肖
            $SXDict = array('鼠','牛','虎','兔','龙','蛇','马','羊','猴','鸡','狗','猪');
            $result = $SXDict[($y-4)%12];
            break;

        }
        return $result;
    }


    function __toString() 
    {
        return $this->format();
    }
}//类定义结束
?>