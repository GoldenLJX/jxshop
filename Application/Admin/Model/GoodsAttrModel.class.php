<?php
namespace Admin\Model;
class GoodsAttrModel extends CommonModel{
    protected $fields = array('id','goods_id','attr_id','attr_values');

    public function insertAttr($attr,$goods_id){
        foreach ($attr as $key =>$value){
            foreach ($value as $v){
                $attr_list[] = array(
                  'goods_id'=>$goods_id,
                  'attr_id'=>$key,
                  'attr_values'=>$v,
                );
            }
        }
        $this->addAll($attr_list);
    }
}
