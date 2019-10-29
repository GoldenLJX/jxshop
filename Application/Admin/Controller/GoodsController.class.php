<?php
namespace Admin\Controller;
class GoodsController extends CommonController
{
    public function showAttr(){
        $type_id = intval(I('post.type_id'));
        if($type_id<=0){
//            echo '没有数据';
            exit;
        }
        $data = D('Attribute')->where('type_id='.$type_id)->select();
        foreach ($data as $key=>$value){
            if($value['attr_input_type']==2){
                //是一个列表选择,因此需要处理默认值
                $data[$key]['attr_value']=explode(',',$value['attr_value']);
            }
        }
        $this->assign('data',$data);
        $this->display();
    }
    //商品的添加功能
    public function add(){
        if(IS_GET){
            //获取分类信息
            $cate = D('Category')->getCateTree();
            $type = D('Type')->select();
            $this->assign('type',$type);
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
            //获取所有的类型
            $type = D('type')->select();
            $this->assign('type',$type);
            //根据商品标识获取当前商品对应的属性及属性值
            $goodsAttrModel = M('GoodsAttr');
            $attr = $goodsAttrModel->alias('a')->field('a.*,b.attr_name,b.attr_type
            ,b.attr_input_type,b.attr_value')->join('left join jx_attribute b on a.attr_id=b.id')->where('a.goods_id='.$goods_id)->select();
            foreach ($attr as $key =>$value){
                if($value['attr_input_type']==2){
                    $attr[$key]['attr_value']=explode(',',$value['attr_value']);
                }
            }
            foreach ($attr as $key =>$value){
               $attr_list[$value]['attr_id'][] = $value;
            }
            $this->assign('attr',$attr_list);
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