<?php
namespace Home\Controller;

class CartController extends CommonController {
    //实现商品添加到购物车
    public function addCart(){
        $goods_id = intval(I('post.goods_id'));
        $goods_count =  intval(I('post.goods_count'));
        $attr = I('post.attr');
        //实例化模型对象调用方法实现数据写入
        $model = D("Cart");
        $res = $model->addCart($goods_id,$goods_count,$attr);
        if(!$res){
            $this->error($model->getError());
        }
        $this->success('写入成功');
    }
    //实现购物车列表显示功能
    public function index(){
        $model = D('Cart');
        //获取购物车中具体的商品信息
        $data=$model ->getList();
        $this->assign('data',$data);
        //计算当前购物车总金额
        $total = $model->getTotal($data);
        $this->display();
    }
    public function dels(){
        $goods_id = intval(I('get.goods_id'));
        $goods_attr_ids = I('get.goods_attr_ids');
        D('Cart')->dels($goods_id,$goods_attr_ids);
        $this->success('删除成功');
    }
    //更新购物车中商品数量
    public function updateCount(){
        $goods_id = intval(I('post.goods_id'));
        $goods_count = intval(I('post.goods_count'));
        $goods_attr_ids = I('post.goods_attr_ids');
        D('Cart')->updateCount($goods_id,$goods_attr_ids,$goods_count);
    }
}