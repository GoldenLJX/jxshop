<?php
namespace Admin\Controller;
//角色控制器

class RoleController extends CommonController{
    //添加角色
    public  function add(){
        if(IS_GET){
            $this->display();
        }else{
            $model = D('Role');
               $data =  $model->create();
               if(!$data){
                   $this->error($model->getError());
               }
               $model->add($data);
               $this->success('角色数据写入成功');
        }

    }
    //显示角色列表
    public function index(){
        $model = D('Role');
        $data = $model->listData();
        $this->assign('data',$data);
        $this->display();
    }
    public function dels(){
        $role_id = intval(I('get.role_id'));
        if($role_id<=1){
            $this->error('参数错误');
        }
        $model = D('Role');
        $res = $model->dels($role_id);
        if(!$res){
            $this->error($model->getError());
        }
        $this->success('角色删除成功');
    }
    //编辑功能
    public function edit(){
       $model = D('Role');
        if(IS_GET){
            $role_id =  $id=$_GET['role_id'];
            $info = $model->findOneById($role_id);
            $this->assign('info',$info);
            $this->display();
        }else{
            $data = $model->create();//根据表单提交post数据创建数据
            if(!data){
                $this->error($model->getError());
            }
            if($data['id']<=1){
                $this->error('参数错误');
            }
            $model->save($data);
            $this->success('修改成功',U('index'));
        }
    }
}