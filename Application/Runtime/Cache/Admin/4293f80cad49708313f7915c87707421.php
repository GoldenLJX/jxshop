<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>ECSHOP 管理中心 - 商品分类列表  </title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/Public/Admin/Styles/general.css" rel="stylesheet" type="text/css" />
<link href="/Public/Admin/Styles/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h1>
    
    <span class="action-span"><a href="<?php echo U('add');?>">添加分类</a></span>
    <span class="action-span1"><a href="<?php echo U('index');?>">ECSHOP 管理中心</a></span>
    <span id="search_id" class="action-span1"> - 商品分类列表 </span>
    <div style="clear:both"></div>

</h1>
<div class="main-div">
    
    <form action="" method="POST" enctype="multipart/form-data">
        <table width="100%" cellspacing="1" cellpadding="2" id="list-table">
            <thead>
            <tr>
                <th width="40"><input type="checkbox" id="selectAll" />全选</th>
                <th>顶级权限</th>
                <th>子权限</th>
            </tr>
            </thead>
            <tbody>

            <tr>
                <td>
                    <input type="checkbox" class="top" name="rule[]" value="<?php echo ($vo["id"]); ?>" >
                </td>
                <td>商品管理</td>
                <td>
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    <input type="checkbox" class="top" name="rule[]" value="<?php echo ($vo["id"]); ?>" >
                </td>
                <td>商品管理</td>
                <td>
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                    <input type="checkbox" class="child" name="rule[]" value="<?php echo ($v["id"]); ?>" />商品添加&nbsp;
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <input type="hidden" name="rid" value="<?php echo ($rid); ?>" />
                    <button type="submit" class="btn btn-default">表单提交</button>
                </td>
            </tr>

            </tbody>
        </table>
    </form>

</div>
<div id="footer">
共执行 3 个查询，用时 0.162348 秒，Gzip 已禁用，内存占用 2.266 MB<br />
版权所有 &copy; 2005-2012 上海商派网络科技有限公司，并保留所有权利。</div>
</body>
</html>
<script type="text/javascript" src="/Public/Admin/Js/jquery-1.8.3.min.js"></script>