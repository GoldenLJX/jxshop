<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 添加管理员 </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    
    <span class="action-span"><a href="<?php echo U('index');?>">商品分类</a></span>
    <span class="action-span1"><a href="#">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 添加管理员 </span>
    <div style="clear:both"></div>

</h1>
<div class="main-div">
    
    <form action="" method="post" name="theForm" enctype="multipart/form-data">
        <table width="100%" id="general-table">
            <tr>
                <td class="label">用户名:</td>
                <td>
                    <input type='text' name='username' maxlength="20" value='<?php echo ($info["username"]); ?>' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">密码:</td>
                <td>
                    <input type='password' name='password' maxlength="20" value='' size='27' /> <font color="red">*</font>
                </td>
            </tr>
            <tr>
                <td class="label">角色选择:</td>
                <td>
                    <select name="role_id">
                        <?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($info["role_id"]) == $vo["id"]): ?>selected="selected"<?php endif; ?>><?php echo ($vo["role_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
        </table>
        <input type="hidden" name="id" value="<?php echo ($info["id"]); ?>">
        <div class="button-div">
            <input type="submit" value=" 确定 " />
            <input type="reset" value=" 重置 " />
        </div>
    </form>

</div>
<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" src="/Public/Admin/Js/jquery-1.8.3.min.js"></script>