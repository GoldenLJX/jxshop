<?php
namespace Home\Controller;

class OrderController extends CommonController {
   //显示出结算的页面
    public function check()
    {
        //判断用户是否登录
        $this->checkLogin();
        $model=D('Cart');
        //获取购物车中具体的商品信息
        $data = $model->getList();
        $this->assign('data',$data);
        //计算当前购物车总金额
        $total = $model->getTotal($data);
        $this->assign('total',$total);
       $this->display();
    }
    //检查用户是否登录
    public function checkLogin(){
        $user_id = session('user_id');
        if(!$user_id){
            $this->error('请先登录',U('User/login'));
        }
    }
}