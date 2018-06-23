<?php 
  include_once '../fn.php';
  isLogin();
  $id=$_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
  <script src="../assets/vendors/nprogress/nprogress.js"></script>
</head>
<body data-userId=<?php echo $id ?>>
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
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="row">
        <div class="col-md-4">
          <form id="userForm">
            <!-- enctype="multipart/form-data" -->
            <h2>添加新用户</h2>
            <input type="hidden" id="userId" name="userId" value="">
            <div class="form-group">
              <label for="avatar">头像</label>
              <input id="avatar" class="form-control" name="avatar" type="file" placeholder="头像">
            </div>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/author/<strong id="strong">slug</strong></p>
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <input class="btn btn-primary btn-add" type="button" value="添加">
              <input class="btn btn-primary btn-update" style="display:none" type="button" value="修改">
              <input class="btn btn-primary btn-cancel" style="display:none" type="button" value="放弃">
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
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="../assets/img/default.png"></td>
                <td>i@zce.me</td>
                <td>zce</td>
                <td>汪磊</td>
                <td>激活</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!-- 添加页面的标记 -->
  <?php $page = "users" ?>
  <!-- 引入aside -->
  <?php include_once './inc/aside.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
      //未激活（unactivated）/ 激活（activated）/ 禁止（forbidden）/ 回收站（trashed）
      var state = {
        unactivated:'未激活',
        activated:'激活',
        forbidden:'禁止',
        trashed:'回收站'
      }
      function render(){
        $.ajax({
          url:'./users/userGet.php',
          dataType:'json',
          success: function(info){
            console.log(info);
            var obj = {
              list:info,
              state:state,
              userId:$('body').attr('data-userId')
            }
            $('tbody').html(template('tmp',obj));
          }
        })
      }
      render();
      $('#slug').on('input',function(){
        $('#strong').text($(this).val()||'slug');
      })
      $('tbody').on('click','.btn-edit',function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          url:'./users/userGetOne.php',
          data:{id:id},
          dataType:'json',
          success:function(info){
            // console.log(info)
            $('#userId').val(info.id);
            $('#slug').val(info.slug);
            $('#nickname').val(info.nickname);
            $('#email').val(info.email);
            $('#password').val(info.password);
            $('#strong').text(info.slug);
            $('.btn-add').hide();
            $('.btn-update,.btn-cancel').show();
          }
        })
      });  
      $('tbody').on('click','.btn-del',function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          url:'./users/userDel.php',
          data:{id:id},
          success:function(info){
            render();
          }
        })
      });

      
      $('.btn-add').click(function(){
        var formData = new FormData($('#userForm')[0]);
        // console.log(formData)
        $.ajax({
          type:'post',
          url:'./users/userAdd.php',
          data:formData,
          contentType:false, //禁止设置请求头
          processData:false, //不用将对象转成 name=zs&age=18..
          success:function(info){
            $('#userForm')[0].reset();
            render()
          }
        })
      })
      $('.btn-cancel').click(function(){
        $('#userForm')[0].reset();
      })
      $('.btn-update').click(function(){
        var formData = new FormData($('#userForm')[0]);
        $.ajax({
          type:'post',
          url:'./users/userUpdate.php',
          data:formData,
          contentType:false,
          processData:false,
          success:function(info){
            $('#userForm')[0].reset();
            render();
            $('.btn-add').show();
            $('.btn-update,.btn-cancel').hide();
          }
        })
      })
    })
  </script>
  <script type="text/template" id="tmp">
    {{ each list v i}}
      <tr>
        <td class="text-center" data-id="{{v.id}}"><input {{v.id == userId ?'disabled':''}} type="checkbox"></td>
        <td class="text-center"><img class="avatar" src="../{{v.avatar}}"></td>
        <td>{{v.email}}</td>
        <td>{{v.slug}}</td>
        <td>{{v.nickname}}</td>
        <td>{{state[v.status]}}</td>
        <td class="text-left" data-id="{{v.id}}">
          <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
          {{ if v.id != userId}}
          <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
          {{/if}}
        </td>
      </tr>
    {{/each}}
  </script>
</body>
</html>
