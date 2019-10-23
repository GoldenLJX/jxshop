<?php
namespace Admin\Controller;
class RuleController extends CommonController
{
    //权限添加
    public function add(){
        if (IS_GET){
            //获取格式化之后的分类信息
            $model=D('Rule');
            $cate = $model->getCateTree();
            //将信息赋值给模板
            $this->assign('cate',$cate);
            $this->display();
        }else{
            //写数据入库
            //实例化模型
            $model = D('Rule');
            //创建数据
            $data = $model->create();//
            if (!$data){
                $this->error($model->getError());
            }
            $insertId = $model->add($data);//将数据插入数据库中
            if(!$insertId){
                $this->error('数据写入失败');
            }
            $this->success('数据写入成功');
        }
    }
    //用于权限列表的显示
    public function index(){
        //1.获取模型
        $model = D('Rule');
        //2.调用模型中格式化之后的方法
        $list = $model->getCateTree();
        $this->assign('list',$list);
        $this->display();
    }
    //控制器中实现删除分类的功能
    public function dels(){
        //获取从页面传过来的id标识
        $id = intval(I('get.id'));
        //判断这个id 是不是符合要求的,是不是小于0的情况
        if($id<=0){
            $this->error('id的参数不正确');
        }
        $model=D('Rule');
        //使用模型调用删除的方法
       $res =  $model->dels($id);
       if($res === false){
           $this->error('删除失败');
       }
       $this->success('删除成功');
    }

    //实现编辑分类的功能
    public function edit(){
        if(IS_GET){
            //显示要编辑的分类信息
            $id= intval(I('get.id'));
            //根据ID参数获取改分类的信息
            $model=D('Rule');
            $info = $model->findOneById($id);
            $this->assign('info',$info);
            $cate = $model->getCateTree();
            $this->assign('cate',$cate);
            $this->display();
        }else{
            //实现数据修改
            $model=D('Rule');
            $data = $model->create();
            $res = $model->update($data);
            if($res===false){
                $this->error($model->getError());
            }
            $this->success('修改成功');
        }
    }

}