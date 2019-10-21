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
    //实现伪删除
    public  function dels(){
        $goods_id = intval(I('get.goods_id'));
        if($goods_id<=0){
            $this->error('参数错误');
        }
        $model = D('Goods');
        $res = $model->setStatus($goods_id);
        if($res === false){
            $this->error('删除失败');
        }
        $this->success('删除成功');
    }
    //实现商品的编辑
    public function edit()
    {
        if(IS_GET){
            $goods_id = intval(I('get.goods_id'));
            $model = D('Goods');
            $info = $model ->findOneById($goods_id);
            if(!$info){
                $this->error('参数错误');
            }
            //获取所有的分类信息
            $cate = D('Category')->getCateTree();
            $this->assign('cate',$cate);
            //扩展分类获取
            $ext_cate_ids =M('GoodsCate')->where("goods_id=$goods_id")->select();
            if(!$ext_cate_ids){
                //对于没有扩展分类的商品手动追加一个元素
                $ext_cate_ids=array(
                    array('msg'=>'no data')
                );
            }
            $this->assign('ext_cate_ids',$ext_cate_ids);

            //对商品描述进行反转移
            $info['goods_body'] = htmlspecialchars_decode($info['goods_body']);
            $this->assign('info',$info);
            $this->display();
        }else{
            $model = D('Goods');
            $data = $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            $res = $model->update($data);
            if($res === false){
                $this->error($model->getError());
            }
            $this->success('修改成功',U('index'));
        }
    }
    //回收站商品列表显示
    public function trash(){
        $cate =D("Category")->getCateTree();
        $this->assign('cate',$cate);
        $model = D('Goods');
        $data = $model->listData(0);
        $this->assign('data',$data);
        $this->display();
    }
    //还原伪删除的商品
    public function recover(){
        $goods_id = intval(I('get.goods_id'));
        $model = D('Goods');
        $res = $model->setStatus($goods_id,1);
        if($res===false){
            $this->error('还原失败!');
        }
        $this->success('还原成功');
    }

    //彻底删除的商品
    public function remove(){
        $goods_id = intval(I('get.goods_id'));
        if ($goods_id<=0){
            $this->error('参数错误');
        }

        $model = D('Goods');
        $res = $model->remove($goods_id);
        if($res===false){
            $this->error('删除失败!');
        }
        $this->success('彻底删除成功');
    }
}