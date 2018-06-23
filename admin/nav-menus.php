<?php 
  include_once '../fn.php';
  isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Navigation menus &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <nav class="navbar">
      <button class="btn btn-default navbar-btn fa fa-bars"></button>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="./loginOut.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>导航菜单</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新导航链接</h2>
            <div class="form-group">
              <label for="text">文本</label>
              <input id="text" class="form-control" name="text" type="text" placeholder="文本">
            </div>
            <div class="form-group">
              <label for="title">标题</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="标题">
            </div>
            <div class="form-group">
              <label for="href">链接</label>
              <input id="href" class="form-control" name="href" type="text" placeholder="链接">
            </div>
            <div class="form-group">
              <label for="href">图标</label><br/>
              <input name="icon" value="fa fa-glass" checked type="radio"><i class="fa fa-glass "></i>&nbsp; &nbsp;
              <input name="icon" value="fa fa-phone" type="radio"><i class="fa fa-phone"></i>&nbsp; &nbsp;
              <input name="icon" value="fa fa-fire" type="radio"><i class="fa fa-fire"></i>&nbsp; &nbsp;
              <input name="icon" value="fa fa-gift" type="radio"><i class="fa fa-gift"></i>&nbsp; &nbsp;
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <input class="btn btn-primary btn-add" type="button" value="添加">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>文本</th>
                <th>标题</th>
                <th>链接</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><i class="fa fa-glass"></i>奇趣事</td>
                <td>奇趣事</td>
                <td>#</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><i class="fa fa-phone"></i>潮科技</td>
                <td>潮科技</td>
                <td>#</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><i class="fa fa-fire"></i>会生活</td>
                <td>会生活</td>
                <td>#</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- 添加页面的标记 -->
  <?php $page = "nav-menus" ?>
  <!-- 引入aside -->
  <?php include_once './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
      function render(){
        $.ajax({
          url:'./nav/navGet.php',
          dataType:'json',
          success: function(info){
            console.log(info);
            $('tbody').html(template('tmp',{list:info}));
          }
        })
      }
      render();
      $('tbody').on('click','.btn-del',function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          url:'./nav/navDel.php',
          data:{id:id},
          success:function(info){
            render()
          }
        })
      })
      $('.btn-add').click(function(){
        var formData = $('#form').serialize();
        $.ajax({
          type:'post',
          url:'./nav/navAdd.php',
          data: formData,
          success: function(info){
            render()
          }
        })
      })
    })
  </script>
  <script type="text/template" id="tmp">
    {{each list v i }}
      <tr>
        <td class="text-center" data-id="{{i}}"><input type="checkbox"></td>
        <td><i class="{{v.icon}}"></i>{{v.text}}</td>
        <td>{{v.title}}</td>
        <td>{{v.href}}</td>
        <td class="text-center" data-id="{{i}}">
          <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
        </td>
      </tr>
    {{/each}}
  </script>
</body>
</html>
