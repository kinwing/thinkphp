<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id$

/**
 +------------------------------------------------------------------------------
 * ThinkPHP公共文件
 +------------------------------------------------------------------------------
 */
// 记录和统计时间（微秒）
function G($start,$end='',$dec=3) {
    static $_info = array();
    if(!empty($end)) { // 统计时间
        if(!isset($_info[$end])) {
            $_info[$end]   =  microtime(TRUE);
        }
        return number_format(($_info[$end]-$_info[$start]),$dec);
    }else{ // 记录时间
        $_info[$start]  =  microtime(TRUE);
    }
}

//记录开始运行时间
G('beginTime');
if(!defined('APP_PATH')) define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
if(!defined('RUNTIME_PATH')) define('RUNTIME_PATH',APP_PATH.'/Runtime/');
if(!defined('APP_DEPLOY')) define('APP_DEPLOY',false); // 应用开发模式 false 调试模式 true 部署模式
$runtime = defined('THINK_MODE')?'~'.strtolower(THINK_MODE).'_allinone.php':'~allinone.php';
if(APP_DEPLOY && is_file(RUNTIME_PATH.$runtime)) {
    // 部署模式直接载入allinone缓存
    $result   =  require RUNTIME_PATH.$runtime;
    C($result);
    unset($result);
}else{
    if(version_compare(PHP_VERSION,'5.0.0','<'))  die('require PHP > 5.0 !');
    // ThinkPHP系统目录定义
    if(!defined('THINK_PATH')) define('THINK_PATH', dirname(__FILE__));
    if(!defined('APP_NAME')) define('APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));
    // 加载运行时文件
    require THINK_PATH."/Common/runtime.php";
    // 加载模式列表文件
    load_think_mode();
}
// 记录加载文件时间
G('loadTime');
?>