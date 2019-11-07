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
}