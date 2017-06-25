<?php
// +----------------------------------------------------------------------
// lvphp核心文件 [ Create Controller packages  ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 lvphp   All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吕万兵   <email/798077009@qq.com>
// +----------------------------------------------------------------------
namespace Lvphp\LvController;
class lvphpController{
      /*
       * 模板文件的调用
       * string $path
       * param $path = '文件夹名/文件名'; $datas 传到页面上的数据
       * 'User/index'
       * */
      static  public function display($path,$datas){
            $filepath =   './View/'.$path.'.html';
            if(file_exists($filepath)){
                  foreach($datas as $k=>$v){
                        $$k = $v;
                  }
                 include $filepath;
            }else {
                  return self::redirect('未找到此模板!',U('Index/show'),1);
            }
      }
      /*
       * 提示跳转
       * $message : 提示消息
       * $url :跳转的url
       * $time :跳转的秒数
       * */
      static public function redirect($message,$url,$time){
            echo "<link rel='stylesheet' type='text/css' href='./Static/css/base.css' />";
            echo "<script src='./Static/js/jquery-1.10.2.min.js'></script>";
            echo "<script src='./Static/js/redirect.js'></script>";
            echo "<body class='parentdiv'>";
            echo "<div class='tippdiv'><p class='tips'>".$message."将在<span class='loginTime' style='color: red'>".$time."</span>s后跳转,您还可以点击<a href='".$url."'> 前往 </a></p></div>";
            echo "<script type=\"text/javascript\">$(function(){redirect(\"$url\",'loginTime');})</script>";
            echo "</body>";
      }
}

?>