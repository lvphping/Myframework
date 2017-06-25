<?php
return  array(
      /*数据库的配置信息*/
    'DB_HOST'=>'127.0.0.2',
    'DB_NAME'=>'root',
    'DB_PAD'=>'root',
    'DB_DATA'=>'laravel_blog',
    'DB_PFIX'=>'laravel_',
    'DB_PORT'=>3306,
    'OPEN_DEBUG'  =>false,//debug调试
    'OPEN_LOG'    =>true,//开启日志
    'LOG_FILE'=>'Log/log.txt',//定义日志文件路径
    'DFT_CONTROLLER'=>'Index',
    'DFT_FUNCTION' =>'index',//默认方法
    'PAGE_SHOW_STATUS'=>1,//分页显示状态 1:显示首页上页 1 2 3下页尾页 2:显示 1 2 3  3:显示 首页 上页 下页尾页


);

?>