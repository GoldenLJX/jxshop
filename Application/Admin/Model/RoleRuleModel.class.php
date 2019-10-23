<?php
namespace Admin\Model;
class RoleRuleModel extends CommonModel{
    protected $fields = array(
        'id','role_id','rule_id'
    );
    public function disfetch($role_id,$rules){
        //1.将当前角色对应的权限删除
        $this->where('role_id = '.$role_id)->delete();
        //2.将最新的权限新写入数据库
        foreach ($rules as $key=>$value){
            $list[]=array(
                'role_id'=>$role_id,
                'rule_id'=>$value,
            );
        }
        $this->addAll($list);
    }
    //根绝角色ID获取对应的权限信息
    public function getRules($role_id){
        return $this->where('role_id='.$role_id)->select();
    }
}