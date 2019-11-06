<?php
namespace Home\Controller;

class UserController extends CommonController {
    public function regist(){
        if(IS_GET){
            $this->display();
        }else{
            $username = I('post.username');
            $password = I('post.password');
            $checkcode = I('post.checkcode');
            //检查验证码是否正确
            $obj = new \Think\Verify();
            if(!$obj->check($checkcode)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
            }
            //实例化
            $model = D('User');
            $res = $model->regist($username,$password);
            if($res){
                $this->ajaxReturn(array('status'=>0,'msg'=>$model->getError()));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
        }
    }

    public function login(){
        if(IS_GET){
            $this->display();
        }else{
            $username = I('post.username');
            $password = I('post.password');
            $checkcode = I('post.checkcode');
            //检查验证码是否正确
            $obj = new \Think\Verify();
            if(!$obj->check($checkcode)){
                $this->ajaxReturn(array('status'=>0,'msg'=>'验证码错误'));
            }
            //实例化
            $model = D('User');
            $res = $model->login($username,$password);
            if($res){
                $this->ajaxReturn(array('status'=>0,'msg'=>$model->getError()));
            }
            $this->ajaxReturn(array('status'=>1,'msg'=>'ok'));
        }
    }
    //登出
    public function logout(){
        session('user',null);
        session('user_id',null);
        $this->redirect('/');
    }
    //生成验证码
    public function code(){
        $obj = new \Think\Verify();
        $obj->entry();
    }

}