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
 * 委托数据库的Dao对象验证用户信息
 +------------------------------------------------------------------------------
 * @category   ORG
 * @package  ORG
 * @subpackage  RBAC
 * @author    liu21st <liu21st@gmail.com>
 * @version   $Id$
 +------------------------------------------------------------------------------
 */
class DaoAuthentictionProvider extends ProviderManager
{//类定义开始

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @static
     * @access public
     +----------------------------------------------------------
     */
    public function authenticate($map,$daoClass='User')
    {
        $dao    = D($daoClass);
        $result = $dao->where($map)->find();
        if($result) {
            $this->data =   $result;
            return true;
        }else {
            return false;
        }
    }

}//类定义结束
?>