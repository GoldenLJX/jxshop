<?php
namespace Home\Controller;

class IndexController extends CommonController {
    public function index(){
        //控制是否展开分类
        $this->assign('is_show',1);
        //获取热卖商品信息
        $goodsModel = D('Admin/Goods');
        $hot = $goodsModel->getRecGoods('is_hot');
        $rec = $goodsModel->getRecGoods('is_rec');
        $new = $goodsModel->getRecGoods('is_new');
        $this->assign('hot',$hot);
        $this->assign('hot',$rec);
        $this->assign('hot',$new);

        $this->display();
    }
}