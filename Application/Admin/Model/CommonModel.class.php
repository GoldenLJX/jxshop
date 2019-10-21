<?php
namespace Admin\Model;
use \Think\Model;

class CommonModel extends Model{
    //根据Id获取指定的数据
    public function findOneById($id){
        return $this->where('id='.$id)->find();
    }
}