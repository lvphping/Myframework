<?php
/**
 * Created by PhpStorm.
 * User: lvphp
 * Date: 2016/11/8
 * Time: 13:54
 */
function __autoload($classname){
      include str_replace('\\','/',__DIR__.'/'.$classname.'.php');
}