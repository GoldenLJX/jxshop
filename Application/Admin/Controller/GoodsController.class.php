<?php
namespace Admin\Controller;
class GoodsController extends CommonController
{
    //商品的添加功能
    public function add(){
        if(IS_GET){
            //获取分类信息
            $cate = D('Category')->getCateTree();
            $this->assign('cate',$cate);
            $this->display();
            exit();
        }
        $model = D('Goods');
        $data = $model->create();
        if(!$data){
            $this->error($model->getError());
        }
        $goods_id = $model->add($data);
        if(!$goods_id){
            $this->error($model->getError());
        }
        $this->success('商品添加成功');
    }
    //商品列表显示
    public function index(){
        //过去分类信息
        $cate =D('Category')->getCateTree();
        $this->assign('cate',$cate);
        $model = D('Goods');
        //调用模型方法获取数据
        $data = $model->listdata();
        $this->assign('data',$data);
        $this->display();
    }
}