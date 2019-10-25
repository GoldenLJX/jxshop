<?php

namespace Admin\Controller;
//角色控制器

class AttributeController extends CommonController{
    protected function model(){
        if(!$this->_model){
            $this->_model = D('Attribute');
        }
        return $this->_model;
    }
    //添加角色
    public function add()
    {
        if (IS_GET) {
            //获取所有的类型信息
            $type = D('Type')->select();
            $this->assign('type', $type);
            $this->display();
        } else {
            $data = $this->model()->create();
            if(!$data){
                $this->error($this->model()->getError());
            }
            $this->model()->add($data);
            $this->success('属性成功写入');
        }

    }

    //显示属性列表
    public function index()
    {
        $data = $this->model()->listData();
        $this->assign('data', $data);
        $this->display();
    }

    public function dels()
    {
        $attr_id = intval(I('get.attr_id'));
        if ($attr_id <= 0) {
            $this->error('参数错误');
        }
        $res = $this->model()->dels($attr_id);
        if (!$res) {
            $this->error($this->model()->getError());
        }
        $this->success('属性删除成功');
    }

    //编辑功能
    public function edit()
    {
        if (IS_GET) {
            $attr_id = $id = $_GET['attr_id'];
            $info = $this->model()->findOneById($attr_id);
            $type = D('Type')->select();
            $this->assign('type', $type);
            $this->assign('info', $info);
            $this->display();
        } else {
            $data = $this->model()->create();//根据表单提交post数据创建数据
            if (!data) {
                $this->error($this->model()->getError());
            }
            if ($data['id'] <= 0) {
                $this->error('参数错误');
            }
            $this->model()->save($data);
            $this->success('修改成功', U('index'));
        }
    }

    public function disfetch()
    {
        if (IS_GET) {
            //获取当前角色拥有的权限信息
            $role_id = intval(I('get.role_id'));
            if ($role_id <= 1) {
                $this->error('参数错误');
            }
            $hasRules = D('RoleRule')->getRules($role_id);
            //对应权限信息进行格式化操作,目的是为了方便使用TP自带的in标签.
            //对应in标签要求是一个一维数组或者是一个字符串格式
            foreach ($hasRules as $key => $value) {
                $hasRulesIds[] = $value['rule_id'];
            }
            $this->assign('hasRules', $hasRulesIds);
            $ruleModel = D('Rule');
            $rule = $ruleModel->getCateTree();
            $this->assign('rule', $rule);
            $this->display();
        } else {
            $role_id = intval(I('post.role_id'));
            if ($role_id <= 1) {
                $this->error('参数错误');
            }
            $rule = I('post.rule');
            D('RoleRule')->disfetch($role_id, $rule);
            //修改角色的权限猴需要将当前角色下的所有文件信息全部删除
            $user_info = M('AdminRole')->where('role_id' . $role_id)->select();
            foreach ($user_info as $key => $value) {
                //删除某个用户的对应的文件信息
                S('user_' . $value['admin_id'], null);
            }
            $this->success('用户权限赋予成功', U('index'));
        }
    }

    //更新超级管理员用户对应的缓存文件
    public function flushAdmin()
    {
        //获取所有的超级管理员用户
        $user = M('AdminRole')->where('role_id=1')->select();
        foreach ($user as $item => $value) {
            S('user_' . $value['admin_id'], null);
        }
        echo 'ok';
    }
}