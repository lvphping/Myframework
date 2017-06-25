<?php
namespace Lvphp\LvController;
class pageController{
      protected $pageSize=10;
      protected $curPage=1;
      protected $pageNum=0;
      function __construct($countNum,$pageSize=10){
            //总页数
            $pageNum=ceil($countNum/$pageSize);
            //判断当前页的页码值是否合法
            if(empty(I('page'))|| I('page')<1){
                  $curPage=1;
            }else if(I('page')>$pageNum){
                  $curPage=$pageNum;
            }else{
                  $curPage=I('page');
            }
            $this->pageSize=$pageSize;
            $this->curPage=$curPage;
            $this->pageNum=$pageNum;
      }
      //获取分页的结果“第一页  上一页  下一页  尾页”??
      //分析参数  总条数  每页的条数  当前页码---get中取
      function showPage(){
            $pageStr = '';
            $baseUrl=$this->baseUrl();
            $lastPage=$this->curPage-1;
            $nextPage=$this->curPage+1;
            if(G('PAGE_SHOW_STATUS') == 1) {
                  if ($this->curPage >= 2) {
                        $pageStr .= "<a href='?{$baseUrl}page=1'>首页</a>";
                        $pageStr .= "<a href='?{$baseUrl}page={$lastPage}'>上一页</a>";
                  }
                  for($i=1;$i<=$this->pageNum;$i++){
                        if($i==$this->curPage){
                              $pageStr.="<b>{$i}</b>";
                        }else{
                              $pageStr.="<a href='?{$baseUrl}page={$i}'>{$i}</a>";
                        }
                  }
                  if ($this->curPage < $this->pageNum) {
                        $pageStr .= "<a href='?{$baseUrl}page={$nextPage}'>下一页</a>";
                        $pageStr .= "<a href='?{$baseUrl}page={$this->pageNum}'>尾页</a>";
                  }
            }
            if(G('PAGE_SHOW_STATUS') == 2) {
                  for ($i = 1; $i <= $this->pageNum; $i++) {
                        if ($i == $this->curPage) {
                              $pageStr .= "<b>{$i}</b>";
                        } else {
                              $pageStr .= "<a href='?{$baseUrl}page={$i}'>{$i}</a>";
                        }
                  }
            }
            if(G('PAGE_SHOW_STATUS') == 3) {
                  if ($this->curPage >= 2) {
                        $pageStr .= "<a href='?{$baseUrl}page=1'>首页</a>";
                        $pageStr .= "<a href='?{$baseUrl}page={$lastPage}'>上一页</a>";
                  }
                  for($i=1;$i<=$this->pageNum;$i++){
                        if($i==$this->curPage){
                              $pageStr.="<b>{$i}</b>";
                        }else{
                              $pageStr.="<a href='?{$baseUrl}page={$i}'>{$i}</a>";
                        }
                  }
                  if ($this->curPage < $this->pageNum) {
                        $pageStr .= "<a href='?{$baseUrl}page={$nextPage}'>下一页</a>";
                        $pageStr .= "<a href='?{$baseUrl}page={$this->pageNum}'>尾页</a>";
                  }
            }
            return $pageStr;
      }
      /*获取当前域名后面的参数*/
      private function baseUrl(){
            $baseUrl="";
            foreach($_GET as $key=>$value){
                  if($key!="page"){
                        $baseUrl.=$key."=".$value."&";
                  }
            }
            return $baseUrl;
      }
      /*
       * 分页的起始页
       * limit('0,10')
       * */
      function startPage(){
            return ($this->curPage-1)*$this->pageSize;
      }
}