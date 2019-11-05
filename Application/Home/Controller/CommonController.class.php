<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

    public function __construct(){
        parent::__construct();
        //获取分类信息,因为很多地方都用得到,所以在公共的控制器中获取
        $cate = D("Admin/Category")->getCateTree();
        $this->assign("cate",$cate);
    }
}