<?php
// +----------------------------------------------------------------------
// | function [ Create function packages  ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 lvphp   All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吕万兵   <email/798077009@qq.com>
// +----------------------------------------------------------------------
/*
 * 路径生成器
 *string $path  : '控制器/方法'
 *array  $param :  '参数'传入的值
 * */
function U($path,$param=array()){
    //重新构造url
    $newurl   = '';
    $newurl  .= localurl.'/index.php?';
    $urlarray = explode('/',$path);
    $newurl  .= 'c='.$urlarray[0].'&m='.$urlarray[1];
    if(is_array($param) && !empty($param)){
       foreach($param as $k=>$v){
             $newurl .= '&'.$k.'='.$v;
       }
    }
    return $newurl;
}

/**
 * 数据库操作 实例化Model
 * @param table
 */
function M($table) {
      $db = new \Model\DatabaseModel($table);
      $db->table($table);
      if (mysqli_connect_errno()){
            throw_exception(mysqli_connect_error());
      }//抛出sql错误
      return $db;
}

/*
 * 获取变量 重新组装
 * $_POST $_GET
 * string $param 'get.id' , 'post.id'
 * string $filter 变量过滤函数名
 * 写法 I('post.id','strip_tags,htmlspecialchars') 默认是  htmlspecialchars
 * */
function I($param,$filter = 'htmlspecialchars'){
    //检测合法性
    if(!empty($param)){
       $strArr = explode('.',$param);
       $filterArr = explode(',',$filter);
       $filterCount = count($filterArr);
       if(count($strArr) > 1){
             //区分是get还是post
             if($strArr[0]=='get'){
                   if($filterCount > 1) {
                         foreach ($filterArr as $k => $v) {
                               if (($k + 1) < $filterCount) {
                                     return $filterArr[$k + 1]($filterArr[$k]($_GET[$strArr[1]]));
                               } else {
                                     break;
                               }
                         }
                   }else{
                         return $filterArr[0]($_GET[$strArr[1]]);
                   }
             }else{
                   if($filterCount > 1) {
                         foreach ($filterArr as $k => $v) {
                               if (($k + 1) < $filterCount) {
                                     return $filterArr[$k + 1]($filterArr[$k]($_POST[$strArr[1]]));
                               } else {
                                     break;
                               }
                         }
                   }else{
                         return $filterArr[0]($_POST[$strArr[1]]);
                   }
             }
       }else{//默认是get接收
             if($filterCount > 1) {
                   foreach ($filterArr as $k => $v) {
                         if (($k + 1) < $filterCount) {
                               return $filterArr[$k + 1]($filterArr[$k]($_GET[$strArr[0]]));
                         } else {
                               break;
                         }
                   }
             }else{
                   return @$filterArr[0]($_GET[$strArr[0]]);
             }
            // echo htmlspecialchars($_GET[$strArr[0]]);
       }
    }else{
          return false;
    }
}

/*
 * 验证邮箱
 * 正则表达式
 * param string $email 邮箱地址
 * */
function  vail_email($email){
      if(preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)){
            return true;
      }else{
            return false;
      }
}
/*
 * 验证手机号码
 * 正则表达式
 * param string $mobile 手机号码
 * */
function vail_mobile($mobile){
      if(preg_match("/^1[34578]{1}\d{9}$/",$mobile)){
            return true;
      }else{
            return false;
      }
}
/*
 * 控制器
 * param string $c
 * $c:控制器名
 * */
function C($c){
   $c = ucfirst($c);
   return '\\Controller\\'.$c.'Controller';
}

// 获取配置值
function G($name = null, $value = null) {
      static $_config = array();
      if (empty($name)){
            return $_config;
      }
      if (is_string($name)) {
            if (!strpos($name, '.')) {
                  $name = strtolower($name);
                  if (is_null($value))
                        return isset($_config[$name]) ? $_config[$name] : null;
                  $_config[$name] = $value;
                  return;
            }
            // 二维数组设置和获取支持
            $name = explode('.', $name);
            $name[0] = strtolower($name[0]);
            if (is_null($value))
                  return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : null;
            $_config[$name[0]][$name[1]] = $value;
            return;
      }
      // 批量设置
      if (is_array($name)) {
            return $_config = array_merge($_config, array_change_key_case($name));
      }
      return null; // 避免非法参数
}

//ajax返回数据
function ajaxReturn($data = null, $message = "", $status) {
      $ret = array();
      $ret["data"] = $data;
      $ret["message"] = $message;
      $ret["status"] = $status;
      echo json_encode($ret);
      die();
}

//调试数组
function _dump($var) {
      if (G("OPEN_DEBUG"))
        dump($var);
}

// 浏览器友好的变量输出
function dump($var, $echo = true, $label = null, $strict = true) {
      $label = ($label === null) ? '' : rtrim($label) . ' ';
      if (!$strict) {
            if (ini_get('html_errors')) {
                  $output = print_r($var, true);
                  $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                  $output = $label . print_r($var, true);
            }
      } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                  $output = preg_replace("/\]\=\>\n(\s+)/m", '] => ', $output);
                  $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
      }
      if ($echo) {
            echo($output);
            return null;
      }
      else
            return $output;
}

/**
 * 调试输出
 * @param type $msg
 */
function _debug($msg) {
      if (G("OPEN_DEBUG"))
            echo "$msg<br />";
}

function _log($filename, $msg) {//检查日志是否开启
      if (G("OPEN_LOG")) {
            $fd = fopen($filename, "a+");
            fwrite($fd, $msg);
            fclose($fd);
      }
}
/**
 * 日志记录
 * @param type $str
 */
function L($msg,$file,$line) {//记录日志
      $time = date("Y-m-d H:i:s");
      $clientIP = $_SERVER['REMOTE_ADDR'];
      $msg = "[$time $clientIP] \n$msg ".$file ."第 ".$line."行\r\n\n";
      $log_file = G("LOG_FILE");
      _log($log_file, $msg);
}




?>