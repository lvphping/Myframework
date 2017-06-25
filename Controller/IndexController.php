<?php
      namespace Controller;
      use Lvphp\LvController\lvphpController;
      use Lvphp\LvController\pageController;

      class IndexController extends lvphpController{
            public function index(){
                  $countNums = M('users')->count();
                  $pageSize = 2;
                  $page = new pageController($countNums,$pageSize);
                  $startPage = $page->startPage();
                  $userData = M('users')->limit("$startPage,$pageSize")->select();
                  $page = $page ->showPage();
                  //echo  I('get.id','vail_email');
                  /*传递数据*/
                  $data = array(
                        'data'=>$userData,
                        'pages'=>$page,
                        'aa'=>10
                  );

                  /*测试文件缓存*/
                  $config = array(
                      'cachePath' => './cache',
                      'keyPrefix' => 'lvphp',
                  );
                  $fileCache = new \Lvphp\LvCache\FileCache($config);
                  $fileCache->set('name', 'sss');
                  echo $fileCache->get('name');
                  /*测试数据缓存*/
                  $configs = array(
                      'keyPrefix' => 'lvphp',
                  );
                  $Arraycache = new \Lvphp\LvCache\ArrayCache($configs);
                  $Arraycache->set('array','bbbb');
                  echo $Arraycache->get('array');
                  /*测试session*/
                  $session = new \Lvphp\LvSession\NativeSession();
                  $session->set('name', 'Ethan');
                  echo $session->get('name');
                  /*测试微信*/
                  

                  self::display("Index/index",$data);
            }
            public function show(){
                  echo "aaaa";
            }
      }
?>