<?php 
  include_once '../fn.php';
  isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/vendors/pagination/pagination.css">  
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="./loginOut.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm btn-approveds">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm btn-dels">批量删除</button>
        </div>
        <!-- <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul> -->
        <!-- 分页的容器 -->
        <!-- pull-right有浮动 -->
        <div class="page-box pull-right"></div>
        
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input class="th-chk" type="checkbox"></th>
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>大大</td>
            <td>楼主好人，顶一个</td>
            <td>《Hello world》</td>
            <td>2016/10/07</td>
            <td>未批准</td>
            <td class="text-center">
              <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
  <!-- 添加页面的标记 -->
  <?php $page = "comments" ?>
  <!-- 引入aside -->
  <?php include_once './inc/aside.php' ?>

  <!-- <script src="../assets/vendors/jquery/jquery.js"></script> -->
  <!-- <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script> -->
  <!-- 引入模板引擎 -->
  <!-- <script src="../assets/vendors/template/template-web.js"></script> -->
  <!-- 引入分页插件 -->
  <!-- <script src="../assets/vendors/pagination/jquery.pagination.js"></script> -->
  <script>NProgress.done()</script>
  <script src="../assets/vendors/require/require.js"></script>
  <script src="../assets/vendors/requireConfig.js"></script>
  <script>
    require(['comments'],function(){});
  </script>
  <script type="text/template" id="tmp">
      {{each list v i}}
        <tr>
          <td class="text-center" data-id= {{ v.id }}><input class="tb-chk" type="checkbox"></td>
          <td>{{v.author}}</td>
          <td>{{ v.content.substr(0,20)+'...' }}</td>
          <td>《{{ v.title }}》</td>
          <td>{{ v.created }}</td>
          <td>{{ state[v.status] }}</td>
          <td class="text-right" data-id= {{ v.id }}>
            <!-- 只有待审核的需要显示批准按钮 -->
            {{if v.status == 'held'}}
            <a href="javescript:;" class="btn btn-info btn-xs btn-approved">批准</a>
            {{ /if}}
            <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
          </td>
        </tr>
      {{/each}}
  </script>
</body>
</html>
