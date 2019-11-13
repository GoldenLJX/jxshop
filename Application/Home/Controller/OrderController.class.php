<?php
namespace Home\Controller;

class OrderController extends CommonController {
    //实现当用户付款成功之后的回跳地址
    public function returnUrl(){
        require_once("../pay/config.php");
        require_once '../pay/pagepay/service/AlipayTradeService.php';
        $arr=$_GET;
        $alipaySevice = new \AlipayTradeService($config);
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取支付宝的通知返回参数，可参考技术文档中页面跳转同步通知参数列表

            //商户订单号
            $out_trade_no = htmlspecialchars($_GET['out_trade_no']);

            //支付宝交易号
            $trade_no = htmlspecialchars($_GET['trade_no']);

            echo "验证成功<br />支付宝交易号：".$trade_no;

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        }
        else {
            //验证失败
            echo "验证失败";
        }
    }
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
    //时效内用户的下单操作
    public function order(){
        $model = D('Order');
        $res = $model->order();
        if(!$res){
            $this->error($model->getError());
        }
        echo '订单OK';
    }
}