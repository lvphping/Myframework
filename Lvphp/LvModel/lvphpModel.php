<?php
// +----------------------------------------------------------------------
// | lvphp核心文件 Model[ Create database packages  ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 lvphp   All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吕万兵   <email/798077009@qq.com>
// +----------------------------------------------------------------------
namespace Lvphp\LvModel;
use mysqli;

class lvphpModel {
      // 数据库连接ID 支持多个连接
      protected $linkID = array();
      // 当前数据库操作对象
      protected $db = null;
      // 当前查询ID
      protected $queryID = null;
      // 当前SQL指令
      public  $queryStr = '';
      // 是否已经连接数据库
      protected $connected = false;
      // 返回或者影响记录数
      protected $numRows = 0;
      // 返回字段数
      protected $numCols = 0;
      // 错误信息
      protected $error = '';
      // 总行数
      protected $rows='';
      public function __construct() {
            $this->db = $this->connect();
      }

      /**
       * 数据库连接
       * @access protected
       * @param
       * @return
       */
      protected function connect($config = '', $linkNum = 0) {
            if (!isset($this->linkID[$linkNum])) {
                  if (empty($config)) {
                        $config = array(
                            'DB_NAME' => G('DB_NAME'),
                            'DB_PAD'  => G('DB_PAD'),
                            'DB_HOST' => G('DB_HOST'),
                            'DB_PORT' => G('DB_PORT'),
                            'DB_DATA' => G('DB_DATA')
                        );
                  }
                  $this->linkID[$linkNum] = new mysqli($config['DB_HOST'], $config['DB_NAME'], $config['DB_PAD'], $config['DB_DATA'], $config['DB_PORT'] ? intval($config['DB_PORT']) : 3306);
                  if (mysqli_connect_errno()){
                              L('数据库链接失败',__FILE__,__LINE__);
                  }
                  $this->connected = true;
            }
            return $this->linkID[$linkNum];
      }
      /*
       *
       * 设置编码方式
       *
       * */
      public function setCharset(){
            $this->db->query('set names utf8');
      }
      /**
       * 初始化数据库连接
       * @access protected
       * @param
       * @return
       */
      protected function initConnect() {
            if (!$this->connected) {
                  $this->db = $this->connect();
            }
      }

      /**
       * 获得所有的查询数据
       * @access private
       * @param string $sql  sql语句
       * @return array
       */
      protected function selects($sql) {
            $this->queryStr = $sql;
            $query = $this->db->query($sql);
            $list = array();
            if (!$query){return $list;}
            while ($rows = $query->fetch_assoc()) {
                  $list[] = $rows;
            }
            return $list;
      }
      /**
       * 执行语句 ， 例如插入，更新  删除操作
       * @access protected
       * @param string $str  sql指令
       * @return int
       */
      protected function execute($sql) {
            if ($this->queryID){$this->free();}
            $result = $this->db->query($sql);
            if ($result === false) {
                  if(G('OPEN_DEBUG')){
                        _debug($this->error());
                  }else if(G('LOG_FILE')){
                        L($this->error(),__FILE__,__LINE__);
                  }else{
                        $this->error();
                  }
                  return false;
            } else {
                  $this->numRows = $this->db->affected_rows;
                  $this->lastInsID = $this->db->insert_id;
                  return $this->numRows;
            }
      }
      /**
       * 查询一条数据
       * @access private
       * @param string $sql  sql语句
       * @return array
       */
      protected function findone($sql) {
            $resultSet = $this->selects($sql);
            if ($resultSet === false ) {
                  return false;
            }
            if (empty($resultSet)) {
                  return null;
            }
            $data = $resultSet[0];
            return $data;
      }
      /**
       * 将值转化成字符串  主要用于数学函数取得关联数组里面的值
       * @access protected
       * @param string $sql  sql语句
       * @return array
       */
      protected function getString($sql){
            $resultSet = $this->selects($sql);
            if ($resultSet === false ) {
                  return false;
            }
            if (empty($resultSet)) {
                  return null;
            }
            $data = $resultSet[0];
            foreach ($data as $v){
                  return $v;
            }
      }

      /**
       * 获得上个sql语句
       * @access protected
       * @param  暂无
       * @return string
       */
      public function getLastSql(){
            return $this->queryStr;
      }

      /**
       * 执行操作
       * @access protected
       * @param  暂无
       * @return string
       */
      protected function query($sql) {
            $this->initConnect();
            if (!$this->db) {return false;}
            $this->queryStr = $sql;
            if ($this->queryID){$this->free();}
            $this->queryID = $this->db->query($sql);
            if ($this->db->more_results()) {
                  while (($res = $this->db->next_result()) != NULL) {
                        $res->free_result();
                  }
            }
            if ($this->queryID === false) {
                  if(G('OPEN_DEBUG')){
                        _debug($this->error());
                  }else if(G('LOG_FILE')){
                        L($this->error(),__FILE__,__LINE__);
                  }else{
                        $this->error();
                  }
                  return false;
            } else {
                  $this->numRows = $this->queryID->num_rows;
                  $this->numCols = $this->queryID->field_count;
                  $this->queryStr =$sql;
                  return $this->getAll();
            }
      }

      /**
       * 获得所有的查询数据
       * @access private
       * @param string $sql  sql语句
       * @return array
       */
      private function getAll() {
            $result = array();
            if ($this->numRows > 0) {
                  for ($i = 0; $i < $this->numRows; $i++) {
                        $result[$i] = $this->queryID->fetch_assoc();
                  }
                  $this->queryID->data_seek(0);
            }
            return $result;
      }

      /**
       * 获得数据库错误信息
       * @access private
       * @param string $sql  sql语句
       * @return array
       */
      public function error() {
            $this->error = $this->db->errno . ':' . $this->db->error;
            if ('' != $this->queryStr) {
                  $this->error .= "\n [ SQL语句 ] : " . $this->queryStr;
            }
            return $this->error;
      }

      /**
       * 释放结果集
       * @access public
       * @param
       * @return
       */
      public function free() {
            $this->queryID->free_result();
            $this->queryID = null;
      }

      /**
       * 关闭数据库
       * @access public
       * @param
       * @return
       */
      public function close() {
            if ($this->db) {
                  $this->db->close();
            }
            $this->db = null;
      }

      /**
       * 销毁对象释放结果集
       * @access public
       * @param string $sql  sql语句
       * @return array
       */
      public function __destruct() {
            if ($this->queryID) {
                  $this->free();
            }
            $this->close();
      }

}