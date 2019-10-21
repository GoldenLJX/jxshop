<?php
namespace Admin\Model;
class GoodsCateModel extends CommonModel{
    public function insertExtCate($ext_cate_id,$goods_id){
        //将商品的扩展分类写入数据库
        $ext_cate_id = array_unique($ext_cate_id);
        foreach ($ext_cate_id as $key=>$value){
            if($value != 0){
                $list[]=array('goods_id'=>$goods_id,'cate_id'=>$value);
            }
        }
        //批量写入数据库,注意:对于写入数据的数组要求索引从0开始并且是数字下标
        $this->addAll($list);
    }
}