<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $admin = cookie('admin');
        if(!$admin){
            $this->error('没有登录',U('Login/login'));
        }
    }
}