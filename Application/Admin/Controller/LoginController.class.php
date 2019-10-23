<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{
    public function login(){
        if(IS_GET){

            $this->display();
        }else{
            //接收验证码进行比对
            $capture = I('post.captcha');
            $verify = new \Think\Verify();
            $res = $verify->check($capture);
            if(!$res){
                $this->error('验证码不正确');
            }
            //接收用户密码调用模型方法进行比对
            $username = I('post.username');
            $password = I('post.password');
            $model = D('Admin');
            $user = $model->login($username,$password);
            if(!$user){
                $this->error($model->getError());
            }
            $this->success('登录成功',U('Index/index'));
        }
    }
    //生成验证码
    public function verify(){
        $config = array('length'=>4);
        $verify = new \Think\Verify($config);
        $verify ->entry();
    }
}