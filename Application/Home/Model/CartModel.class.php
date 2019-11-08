<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model{
    //自定义字段信息
    protected $fields=array('id','user_id','goods_id','goods_count','goods_attr_ids');
    //作用就是实现具体商品信息假如到购物车
    public function addCart($goods_id,$goods_count,$attr){
        //将属性信息做一个从小到大的排序操作
        sort($attr);
        //将属性信息转为字符串的格式
        $goods_attr_ids = $attr ? implode(',',$attr) : '';
        //实现库存量检查
        $res = $this->checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids);
        if(!$res){
            $this->error='库存不足';
            return false;
        }

        //获取用户的ID标识
        $user_id = session('user_id');
        if($user_id){
            //说明用户已经登录 接下来数据的操作去操作对应的数据表
            //根据当前要写入的数据信息判断数据库中是否存在,如果存在在直接更新对应的数量
            $map = array(
                'user_id'=>$user_id,
                'goods_id'=>$goods_id,
                'goods_attr_ids'=>$goods_attr_ids
            );
            $info = $this->where($map)->find();
            if($info){
                //说明数据已经存在 已经存在需要更新对应的数量
                $this->where($map)->setField('goods_count',$goods_count + $info['goods_count']);
            }else{
//                说明目前数据不存在 直接写入数据即可
                $map['goods_count']=$goods_count;
                $this->add($map);
            }
        }else{
            //表示用户没有登录 对应的操作cookie中的数据
            //规定关于商品假如购物车cookie中记录数据 使用cart的名称,对于数据从php中的数组转换为字符串是通过序列化操作
            $cart = unserialize(cookie('cart'));
            //先判断目前添加的商品信息是否存在
            //首先先拼接处对应的key下标
            $key = $goods_id.'-'.$goods_attr_ids;
            if(array_key_exists($key,$cart)){
                //说明目前添加的商品信息已经存在
                $cart[$key] += $goods_count;
            }else{
                //说明目前添加的商品信息不存在
                $cart[$key]=$goods_count;
            }
            //处理完之后需要将最新的数据再次写入cookie
            cookie('cart',serialize($cart));
        }
        return true;
    }
    //实现商品库存的检查
    public function checkGoodsNumber($goods_id,$goods_count,$goods_attr_ids){
        //1.检查总的库存量
        $goods = D('Admin/Goods')->where("id = $goods_id")->find();
        if($goods['goods_number']<$goods_count){
            //表示库存不足
            return false;
        }
        //2.根据单选属性检查对应的属性组合库存量
        if($goods_attr_ids){
            $where="goods_id = $goods_id and goods_attr_ids = $goods_attr_ids";
            $number = M('GoodsNumber')->where($where)->find();
            if(!$number||$number['goods_number']<$goods_count){
                return false;
            }
        }
        return true;
    }

    //体局实现购物车cookie的数据转移到数据库中
    public function cookieToDB(){
        //获取cookie中购物车的数据
        $cart = unserialize(cookie('cart'));
        //获取当前用户的ID标识
        $user_id = session('user_id');
        if(!$user_id){
            return false;
        }
        foreach ($cart as$key=>$value){
            //先将目前的下标对应的商品ID以及属性值组合拆分出来
            $tmp=explode('-',$key);
            //先拼接条件查询当前商品信息是否存在
            $map = array(
                'user_id'=>$user_id,
                'goods_id'=>$tmp[0],
                'goods_attr_ids'=>$tmp[1],
            );
            $info = $this->where($map)->find();
            if($info){
                //说明数据已经存在 已经存在需要更新对应的数量
                $this->where($map)->setField('goods_count',$value + $info['goods_count']);
             }else{
                $map['goods_count']=$value;
                $this->add($map);
            }
        }
        cookie('cart',null);
    }
    //获取购物车中的商品信息
    public function getList(){
        //获取当前购物车中对应的信息
        $user_id = session('user_id');
        if($user_id){
            //表示用户已经登录,可以从数据库中获取购物车的数据
            $data = $this->where('id='.$user_id)->select();
        }else{
            //没有登录 直接从cookie中获取对应的购物车的数据
            $cart = unserialize(cookie('cart'));
            //将没有登录的购物车的数据转换为数据库中的格式
            foreach ($cart as$key=>$value){
                $tmp = explode('-',$key);
                $data[] = array(
                    'user_id'=>$tmp[0],
                    'goods_attr_ids'=>$tmp[1],
                    'goods_count'=>$value
                );
            }
        }
        //2.根据购物车中商品的ID标识获取商品信息
        $goodsModel = D('Admin/Goods');
        foreach($data as $key => $value){
            $goods = $goodsModel ->where('id= '.$value['goods_id'])->find();
            //根据商品是否处于促销状态设置价格
            if($goods['cx_price']>0 && $goods['start']<time() && $goods['end']>time()){
                //处于促销状态因此设置对应的shop_price为促销价格
                $goods['shop_price'] = $goods['cx_price'];
            }
            $data[$key]['goods'] = $goods;
            //3.根据商品对应的属性值得组合获取对应的属性名称跟属性值
            if($value['goods_attr_ids']){
                //获取商品的属性信息
                $attr = M('GoodsAttr')->alias('a')->join('left join jx_attribute b on a.attr_id = b.id')->
                field('a.attr_values,b.attr_name')->where("a.id in ({$value['goods_attr_ids']})")->select();
                $data[$key]['attr'] = $attr;
            }
        }
        return $data;
    }
    //实现购物车中总金额的计算
    public function getTotal($data){
        $count = $price = 0;
        foreach ($data as $key =>$value){
            $count+=$value['goods_count'];
            $price+=$value['goods_count']*$value['goods']['shop_price'];
        }
        return array(
            'count'=>$count,
            'price'=>$price
        );
    }

    //实现删除的方法
    public function dels($goods_id,$goods_attr_ids){
        $goods_attr_ids = $goods_attr_ids?$goods_attr_ids:'';
        $user_id = session('user_id');
        if($user_id){
            $where = "user_id = '$user_id' and goods_id = '$goods_id' and goods_attr_ids = '$goods_attr_ids'";
            $this->where($where)->delete();
        }else{
            $cart = unserialize(cookie('cart'));
            //手动的拼接当前商品对应的key信息
            $key = $goods_id.'-'.$goods_attr_ids;
            unset($cart[$key]);
            //将最新的数据再次写入到cookie中
            cookie('cart',serialize($cart));
        }
    }
    //实现对购物车中商品数量的更新
    public function updateCount($goods_id,$goods_attr_ids,$goods_count){
    //增加判断当前$goods_count值小于等于0时不进行更新
        if($goods_count<=0){
            return false;
        }
        $goods_attr_ids = $goods_attr_ids?$goods_attr_ids:'';

        $user_id = session('user_id');
        if($user_id){
            $where = "user_id= $user_id and goods_id = $goods_id and goods_attr_ids= $goods_attr_ids";
            $this->where($where)->setField('goods_count',$goods_count);
        }else{
            $cart = unserialize(cookie('cart'));
        }
    }
}