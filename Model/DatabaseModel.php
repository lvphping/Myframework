<?php
// +----------------------------------------------------------------------
// DatabaseModel [ Create databaseModel packages  ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 lvphp   All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吕万兵   <email/798077009@qq.com>
// +----------------------------------------------------------------------
namespace Model;

use Lvphp\LvModel\lvphpModel;

class DatabaseModel extends lvphpModel{
      /**
       * 申明变量操作
       * @param 暂无
       */
      protected $tableName="";
      protected $where="";
      protected $field="*";
      protected $group="";
      protected $having="";
      protected $order="";
      protected $limit="";
      protected $join="";
      function table($tableName){
            $this->tableName=$tableName;
            return $this;
      }
      function __call($functionName,$arr){//当给一个没有定义的属性赋值时 自动跳转到此方法
            $this->$functionName=$arr[0];
            return $this;
      }
      /**
       * 添加操作
       * @param $arr 关联数组
       */
      function add($arr){//添加
            $fieldStr="";
            $valueStr="";
            foreach($arr as $key=>$value){
                  $fieldStr.=",".$key;
                  $valueStr.=",'".$value."'";
            }
            $fieldStr=substr($fieldStr,1);
            $valueStr=substr($valueStr,1);
            $sql="insert into {$this->tableName}({$fieldStr}) values({$valueStr})";
            return $this->exec1ute($sql);
      }
      /**
       * 删除操作
       * @param 暂无
       */
      function delete(){
            $this->init();
            $sql="delete from {$this->tableName} {$this->where}";
            return $this->execute($sql);
      }
      /**
       * 查询操作
       * @param 暂无
       */
      function select(){
            $this->init();
            $sql="select {$this->field} from {$this->tableName} {$this->join} {$this->where} {$this->group} {$this->having} {$this->order} {$this->limit}";
            return $this->selects($sql);
      }

      /**
       * 修改操作
       * @param $arr 关联数组
       */
      function update($arr){
            $fvStr="";
            foreach($arr as $key=>$value){
                  $fvStr.=",".$key."='{$value}'";
            }
            $fvStr=substr($fvStr,1);
            $this->init();
            $sql="update {$this->tableName} set {$fvStr} {$this->where}";
            return $this->execute($sql);
      }
      /**
       * 查询一条记录的操作
       * @param 暂无
       */
      function find(){
            $this->init();
            $sql="select {$this->field} from {$this->tableName} {$this->where}";
            return $this->findone($sql);
      }
      /**
       * 根据字段查找出值操作
       * @param $str 格式 $str='id,username'
       */
      function getField($str){
            $this->init();
            $sql="select {$this->field} from {$this->tableName} {$this->where} {$this->limit}";
            return $this->selects($sql);
      }

      /**
       * 打印上个执行的sql语句
       * @param $str 格式
       */
      function getLastSql(){
            return $this->queryStr;
      }

      /**-------------------------------------数学函数-------------------------------**/
      /**
       * 统计函数
       * @param int
       */
      function count(){
            $this->init();
            $sql="select count(*) from {$this->tableName} {$this->where} {$this->limit}";
            return $this->getString($sql);
      }
      /**
       * 最大值函数
       * @param str  'id'
       */
      function max($str){
            $this->init();
            $sql="select max($str) from {$this->tableName} {$this->where} {$this->limit}";
            return $this->getString($sql);
      }
      /**
       * 最小值函数
       * @param string
       */
      function min($str){
            $this->init();
            $sql="select min($str) from {$this->tableName} {$this->where} {$this->limit}";
            return $this->getString($sql);
      }
      /**
       * 求和函数
       * @param string
       */
      function sum($str){
            $this->init();
            $sql="select sum($str) from {$this->tableName} {$this->where} {$this->limit}";
            return $this->getString($sql);
      }
      /**
       * 自动加载 所需要的条件
       * @param string
       */
      function init(){
            if(!empty($this->field) && !$this->field=='*'){
                  $this->field=$this->field;
            }
            if(!empty($this->join)){
                  $this->join="join ".$this->join;
            }
            if(!empty($this->where)){
                  $this->where="where ".$this->where;
            }
            if(!empty($this->group)){
                  $this->group="group by ".$this->group;
            }
            if(!empty($this->having)){
                  $this->having="having ".$this->having;
            }
            if(!empty($this->order)){
                  $this->order="order by ".$this->order;
            }
            if(!empty($this->limit)){
                  $this->limit="limit ".$this->limit;
            }
      }
}