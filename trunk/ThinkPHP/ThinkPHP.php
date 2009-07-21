<?php
// +----------------------------------------------------------------------
// | ThinkPHP
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
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

//记录开始运行时间
$GLOBALS['_beginTime'] = microtime(TRUE);
if(!defined('APP_PATH')) define('APP_PATH', dirname($_SERVER['SCRIPT_FILENAME']));
if(!defined('RUNTIME_PATH')) define('RUNTIME_PATH',APP_PATH.'/Runtime/');

if(defined('RUNTIME_ALLINONE') && is_file(RUNTIME_PATH.'~allinone.php')) {
    // ALL_IN_ONE 模式直接载入allinone缓存
    $result   =  require RUNTIME_PATH.'~allinone.php';
    C($result);
    // 自动设置为运行模式
    define('RUNTIME_MODEL',true);
}else{
    if(version_compare(PHP_VERSION,'5.0.0','<') ) {
        die('require PHP > 5.0 !');
    }
    // ThinkPHP系统目录定义
    if(!defined('THINK_PATH')) define('THINK_PATH', dirname(__FILE__));
    if(!defined('APP_NAME')) define('APP_NAME', basename(dirname($_SERVER['SCRIPT_FILENAME'])));
    if(is_file(RUNTIME_PATH.'~runtime.php')) {
        // 加载框架核心缓存文件
        // 如果有修改核心文件请删除该缓存
        require RUNTIME_PATH.'~runtime.php';
    }else{
        // 加载常量定义文件
        require THINK_PATH.'/Common/defines.php';
        // 加载路径定义文件
        require defined('PATH_DEFINE_FILE')?PATH_DEFINE_FILE:THINK_PATH.'/Common/paths.php';
        // 定义核心编译的文件
        $runtime[]  =  THINK_PATH.'/Common/functions.php'; // 系统函数
        if(version_compare(PHP_VERSION,'5.2.0','<') ) {
            // 加载兼容函数
            $runtime[]	=	 THINK_PATH.'/Common/compat.php';
        }
        // 核心基类必须加载
        $runtime[]  =  THINK_PATH.'/Lib/Think/Core/Think.class.php';

        // 加载核心编译文件列表
        if(is_file(CONFIG_PATH.'core.php')) {
            // 加载项目自定义的核心编译文件列表
            $list   =  include CONFIG_PATH.'core.php';
        }else{
            if(defined('THINK_MODE')) {
                // 根据设置的运行模式加载不同的核心编译文件
                $list   =  include THINK_PATH.'/Mode/'.strtolower(THINK_MODE).'.php';
            }else{
                // 默认核心
                $list   =  include THINK_PATH.'/Common/core.php';
            }
        }
        $runtime   =  array_merge($runtime,$list);
        // 加载核心编译文件列表
        foreach ($runtime as $key=>$file){
            if(is_file($file)) {
                require $file;
            }
        }
        // 加载编译需要的函数文件
        require THINK_PATH."/Common/runtime.php";
        // 检查项目目录结构 如果不存在则自动创建
        if(!is_dir(RUNTIME_PATH)) {
            // 创建项目目录结构
            buildAppDir();
        }else{
            // 检查缓存目录
            checkRuntime();
        }
        // 生成核心编译缓存 去掉文件空白以减少大小
        if(!defined('NO_CACHE_RUNTIME')) {
            $compile = defined('RUNTIME_ALLINONE');
            $content  = compile(THINK_PATH.'/Common/defines.php',$compile);
            $content .= compile(defined('PATH_DEFINE_FILE')?   PATH_DEFINE_FILE  :   THINK_PATH.'/Common/paths.php',$compile);
            foreach ($runtime as $file){
                $content .= compile($file,$compile);
            }
            file_put_contents(RUNTIME_PATH.'~runtime.php',strip_whitespace('<?php'.$content));
            unset($content);
        }
    }
}
// 记录加载文件时间
$GLOBALS['_loadTime'] = microtime(TRUE);
?>