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
            //获取上商品对应的相册图片信息
            $goods_img_list = M('GoodsImg')->where('goods_id='.$goods_id)->select();
            $this->assign('goods_img_list',$goods_img_list);
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
    //删除相册中的图片
    public function delImg(){
        //使用request目的是为了方便浏览器直接测试使用
        $img_id = intval(I('post.img_id'));
        if($img_id<=0){
            $this->ajaxReturn(array('status'=>0,'msg'=>'参数错误'));
        }
        //先将图片删除掉
        $imgModel = D('GoodsImg');
        $info = $imgModel->where('id='.$img_id)->find();
        if(!$info){
            $this->ajaxReturn(array('status'=>0,'msg'=>'参数错误'));
        }
        unlink($info['goods_img']);
        unlink($info['goods_thumb']);
        //再将
        $imgModel->where('id='.$img_id)->delete();
        $this->ajaxReturn(array('status'=>1,'msg'=>'OK'));
    }

    //设置商品库存设置
    public function setNumber()
    {
        if(IS_GET){
            $goods_id = intval(I('get.goods_id'));
            //通过商品的标识获取对应的单选属性值及属性信息
            $GoodsAttrModel = D('GoodsAttr');
            $attr = $GoodsAttrModel->getSigleAttr($goods_id);
            if(!$attr){
                //针对没有单选属性的商品获取对应的库存信息
                $info = D('Goods')->where('id='.$goods_id)->find();
                $this->assign('info',$info);
                //该商品没有单选属性
                $this->display('nosigle');
                exit;
            }
            //针对有单选属性的库存信息获取
            $info = M('GoodsNumber')->where('goods_id='.$goods_id)->select();
            if(!$info){
                //没有获取到对应的库存信息，为了保证模板能够正常显示至少需要一次循环
                $info=array('goods_number'=>0);
            }
            $this->assign('info',$info);
            $this->assign('attr',$attr);
            $this->display();
        }else{
            $attr = I('post.attr');
            $goods_number = I('post.goods_number');
            $goods_id = I('post.goods_id');

            if(!$attr){
                //没有单选属性的数据提交
                D('Goods')->where('id='.$goods_id)->setField('goods_number',$goods_number);
                exit;
            }
            //通过循环处理组合 最后数据入库
            foreach ($goods_number as $key => $value) {
                //拼接处具体的组合信息
                $tmp=array();
                foreach ($attr as $k => $v) {
                    $tmp[]=$v[$key];
                }
                //将组合的数组格式转换为字符串的格式
                //例如3,4 根4,3是同一个属性组合
                //对$tmp进行一个排序操作
                sort($tmp);
                $goods_attr_ids=implode(',',$tmp);
                //实现组合的去重
                if(in_array($goods_attr_ids, $has)){
                    //重复
                    //手动去掉$goods_number中对应的库存量
                    unset($goods_number[$key]);
                    continue;
                }
                $has[]=$goods_attr_ids;
                $list[]=array(
                    'goods_id'=>$goods_id,
                    'goods_number'=>$value,
                    'goods_attr_ids'=>$goods_attr_ids,
                );
            }
            //实现删除当前商品以及拥有的库存信息
            M('GoodsNumber')->where('goods_id='.$goods_id)->delete();
            //将库存信息入库
            M('GoodsNumber')->addAll($list);
            //计算当前库存总数
            $goods_count = array_sum($goods_number);
            D('Goods')->where('id='.$goods_id)->setField('goods_number',$goods_count);
        }
    }
}