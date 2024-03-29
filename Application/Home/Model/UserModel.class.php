<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
    protected $fields=array('id','username','password','salt');
    //实现用户的信息入库
    public function regist($username,$password){
        //检查用户名是否可用
        $info = $this->where("username ='$username'" )->find();
        if(!$info){
            $this->error='用户名重复';
            return false;
        }
        //生成盐
        $salt = rand(100000,999999);
        //生成双重MD5之后的密码
        $db_password = md5(md5($password).$salt);
        $data = array(
          'username'=>$username,
          'password'=>$db_password,
          'salt'=>$salt,
        );
        return  $this->add($data);
    }
    //实现登录
    public function login($username,$password){
        //检查用户名是否存在
        $info = $this->where("username =".$username )->find();
        if(!$info){
            $this->error='用户名不存在';
            return false;
        }
        //生成双重MD5之后的密码 然后与数据库中的密码进行对比
        $pwd = md5(md5($password).$info['salt']);
        if($pwd !=$info['password']){
            $this->error='密码不正确';
            return false;
        }
        //保存用户的登录状态
        session("user",$info);
        session("user_id",$info['id']);
        //实现购物车cookie中的数据转移到数据库中
        D('Cart')->cookieToDB();
        return  true;
    }
}