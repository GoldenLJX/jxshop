<?php
namespace Admin\Controller;
class AdminController extends CommonController{
    public function add(){
        if(IS_GET){
            //获取所有的角色
            $role = D('Role')->select();
            $this->assign('role',$role);
            $this->display();
        }else{
            $model = D('Admin');
            $data =  $model->create();
            if(!$data){
                $this->error($model->getError());
            }
            $model->add($data);
            $this->success('管理员数据写入成功');
        }
    }

    //显示管理员列表
    public function index(){
        $model = D('Admin');
        $data = $model->listData();
        $this->assign('data',$data);
        $this->display();
    }
    //删除管理员
    public function dels(){
        $admin_id = intval(I('get.admin_id'));
        if($admin_id<=1){
            $this->error('参数错误');
        }
        $model = D('Admin');
        $res = $model->remove($admin_id);
        if(!$res){
            $this->error($model->getError());
        }
        $this->success('管理员删除成功');
    }

    //编辑功能
    public function edit(){
        $model = D('Admin');
        if(IS_GET){
            $admin_id =$_GET['admin_id'];
            //获取用户名和密码以及对应的角色ID
            $info = $model->findOne($admin_id);
            //获取所有的角色
            $role = D('Role')->select();
            $this->assign('info',$info);
            $this->assign('role',$role);
            $this->display();
        }else{
            $data = $model->create();//根据表单提交post数据创建数据
            if(!data){
                $this->error($model->getError());
            }
            if($data['id']<=1){
                $this->error('参数错误');
            }
            $model->update($data);
            $this->success('修改成功',U('index'));
        }
    }
}