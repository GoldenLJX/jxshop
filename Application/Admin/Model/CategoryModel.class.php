<?php
namespace Admin\Model;
class CategoryModel extends CommonModel{
    //自定义字段
    protected $fields =array('id','cname','parent_id','isrec');
    //自动验证
    protected $_validate=array(
        array('cname','require','分类名称必须填写'),
    );

    //格式化分类的数据
    public function getCateTree($id=0){
        //先获取所有的分类信息
        $data = $this->select();
        //在对获取的信息进行个格式化
        $list = $this->getTree($data,$id);
        return $list;
    }
    //获取某个分类下面的子分类
    public function getChildren($id){
        //先获取所有的分类信息
        $data = $this->select();
        //在对获取的信息进行个格式化
        $list = $this->getTree($data,$id,1,false);
        foreach ($list as$ite=>$value){
            $tree[] = $value['id'];
        }
        return $tree;
    }
    public function getTree($data,$id=0,$lev=1,$isCache=true){
        static $list = array();
        //根据参数决定是否需要重置数组
        if(!$isCache){
            $list=array();
        }
        foreach ($data as $key=>$value){
            if ($value['parent_id']==$id){
                $value['lev']=$lev;
                $list[]=$value;
                //使用递归的方式获取分类下的字分类
                $this->getTree($data,$value['id'],$lev+1);
            }
        }
        return $list;
    }
    //根据id标识删除分类
    public function dels($id){
        //首先判断这个分类下边是否还有二级菜单,如果有则不允许删除
        $result = $this->where('parent_id='.$id)->find();//因为模型中有parent_id这个字段,如果传进来的id正好等于它,说明有二级分类
        if($result){//进到这里说明是有二级分类的,不能删除
            return false;
        }
        return $this->where('id='.$id)->delete();
    }
    //跟新数据,这个是重点好好理解一下实现的逻辑
    public function update($data){
        //需要过滤掉设置父类为自己以及自己的子分类
        //根据要修改的分类的ID将自己的所有的字分类全部查询出来
        $tree = $this->getCateTree($data['id']);
        //将自己添加到不能修改的数组中
        $tree[]  = array('id'=>$data['id']);

        //如果提交的parent_id值等于自己及子分类下的某个ID直接不容许修改
        foreach($data as $key =>$value){
            if($data['parent_id']==$value['id']){
                $this->error='不能设置子分类为父分类';
                return false;
            }
        }
        return $this->save($data);
    }
}