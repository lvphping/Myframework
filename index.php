<?php
// +----------------------------------------------------------------------
// lvphp index.php [ Create index.php  ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 lvphp   All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吕万兵   <email/798077009@qq.com>
// +----------------------------------------------------------------------
      /*错误提示
      ini_set("display_errors",0);
      ini_set("error_reporting",E_ALL);
      ini_set("error_log","log.txt");
      ini_set("log_errors",1);
      */
      ini_set('date.timezone','Asia/Shanghai');
      //包含全局方法
      require __DIR__.'/Common/function.php';
      //包含配置文件
      G(include './Config/config.php');
      //记载自动加载类
      require __DIR__."/autoload.php";
      //定义常量
      define("localurl",'http://'.$_SERVER['SERVER_NAME'].'/Myframework');
      define("static_path",localurl.'/Static/');
      //接收用户访问的控制器
      $c = isset($_GET['c']) && !empty($_GET['c']) ? C($_GET['c']) : C(G('DFT_CONTROLLER'));
      //接受用户访问的方法
      $m = isset($_GET['m']) && !empty($_GET['m']) ? $_GET['m'] : G('DFT_FUNCTION');
      $r = new $c();
      echo $r->$m();
?>