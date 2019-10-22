<?php
namespace Admin\Model;
class AdminModel extends CommonModel{
    //自定义字段
    protected $fields = array('id','username','password');
    //自动验证
    protected $_validate = array(
        array('username','require','用户名必须填写'),
        array('username','','用户名重复了',1,'unique'),
        array('password','require','密码必须填写'),
    );
    //自动完成
    protected $_auto=array(
        array("password",'md5',3,'function')
    );
    //使用TP中的钩子函数实现 中间表的入库
    protected function _after_insert($data)
    {
        $admin_role = array(
            'admin_id'=>$data['id'],
            'role_id'=>I('post.role_id')
        );
        M('AdminRole')->add($admin_role);//插入中间表的数据库
    }
    //显示管理员列表
    public function listData(){
        //定义页尺寸
        $pagesize = 3;
        //计算数据总数
        $count = $this->count();
        //生成分页导航信息
        $page = new \Think\Page($count,$pagesize);
        //得到分页导航信息
        $show = $page->show();
        //接收当前所在的页码
        $p = intval(I('get.p'));
        $list = $this->alias('a')->field('a.*,c.role_name')->join(
            'left join jx_admin_role b on a.id=b.admin_id')->join(
                'left join jx_role c on b.role_id=c.id')->page($p,$pagesize)->select();
        return array('pageStr'=>$show,'list'=>$list);
    }
    //删除管理员
    public function remove($admin_id){
        dump($admin_id);
        //开启事务,因为要删除两个表里的数据,一起删除才可以,删除一个不成功
        $this->startTrans();
        //1.删除admin中的用户
        $userStatus = $this->where('id='.$admin_id)->delete();
        if(!$userStatus){
            $this->rollback();
            return false;
        }
        //2.删除admin_role中的用户
        $roleStatus = M('AdminRole')->where('admin_id='.$admin_id)->delete();
        if(!$roleStatus){
            $this->rollback();
            return false;
        }
        $this->commit();
        return true;
    }
    //这个方法主要是显示管理员表对应的角色名,涉及到两张表
    public function findOne($admin_id){
        return $this->alias('a')->field('a.*,b.role_id')->join('left join 
        jx_admin_role b on a.id=b.admin_id')->where('a.id='.$admin_id)->find();
    }

    public function update($data){
        $role_id = intval(I('post.role_id'));
        //1.修改用户的基本信息
        $this->save($data);
        //2.修改用户对应的角色
        M('AdminRole')->where('admin_id='.$data['id'])->save(array(
           'role_id'=>$role_id
        ));
    }
}