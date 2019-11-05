<?php
namespace Home\Controller;

class GoodsController extends CommonController {
    public function index(){

        $goods_id = intval(I('get.goods_id'));
        if($goods_id<=0){
            $this->redirect('Index/index');
        }
        $goodsModel  = D("Admin/Goods");
        $goods = $goodsModel->where('is_sale=1 and id='.$goods_id)->find();
        if(!$goods){
            $this->redirect('Index/index');
        }
        //将商品描述信息格式化
        $goods['goods_body']= htmlspecialchars_decode($goods['goods_body']);
        //获取商品对应的相册信息
        $pic  = M('GoodsImg')->where('goods_id ='.$goods_id)->select();
        //获取当前商品对应的属性信息
        $attr = M('GoodsAttr')->alias('a')->field('a.*,b.attr_name,b.attr_type')->
        join('left join jx_attribute b on a.attr_id = b.id')->where('a.goods_id='.$goods_id)->select();
        //对获取到的属性进行格式化操作
        foreach($attr as $key =>$value){
            if($value['attr_type']==1){
                $unique[] = $value;
            }else{
                $sigle[$value['attr_id']][] = $value;
            }
        }
        $this->assign('unique',$unique);
        $this->assign('sigle',$sigle);
        $this->assign('pic',$pic);
        $this->assign('goods',$goods);
        $this->display();
    }
}