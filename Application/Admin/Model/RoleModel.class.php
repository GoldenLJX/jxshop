<?php
namespace Admin\Model;
class RoleModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','role_name');
    //自动验证
    protected $_validate = array(
        array('role_name','require','角色名必须填写'),
        array('role_name','','角色名重复了',1,'unique'),
    );
    //显示出角色的列表
    public  function listData(){
        //定义页尺寸
        $pagesize = 10;
        //计算数据总数
        $count = $this->count();
        //生成分页导航信息
        $page = new \Think\Page($count,$pagesize);
        //得到分页导航信息
        $show = $page->show();
        //接收当前所在的页码
        $p = intval(I('get.p'));
        $list = $this->page($p,$pagesize)->select();
        return array('pageStr'=>$show,'list'=>$list);
    }
    //删除角色
    public function dels($role_id){
        return $this->where('id='.$role_id)->delete();
    }

}