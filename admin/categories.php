<?php 
  include_once '../fn.php';
  isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
        <li><a href="profile.html"><i class="fa fa-user"></i>个人中心</a></li>
        <li><a href="./loginOut.php"><i class="fa fa-sign-out"></i>退出</a></li>
      </ul>
    </nav>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span class="alert-msg"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="form">
            <h2>添加新分类目录</h2>
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong id="strong">slug</strong></p>
            </div>
            <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <input class="btn btn-primary btn-add"  type="button" value="添加">
              <input class="btn btn-primary btn-update"  type="button" value="修改" style="display:none">
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
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
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
  <?php $page = "categories" ?>
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
          url:'./categories/cateGet.php',
          dataType: 'json',
          success: function(info){
            //console.log(info);
            var obj = {
              list:info
            }
            $('tbody').html(template('tmp',obj))
          }
        })
      }
      render();
      
      $('.btn-add').click(function(){
        var formData = $('#form').serialize();
        $.ajax({
          url:'./categories/cateAdd.php',
          data:formData,
          beforeSend:function(){
            if($('#name').val().trim()==""||$('#slug').val().trim()==""){
              $('.alert').show();
              $('.alert-msg').text('名称和别名不能为空！');
              return false;
            } else {
              $('.alert').hide();
            }
          },
          success:function(info){
            render();
            $('#form')[0].reset();
          }

        })
      })
      $('#slug').on('input', function () {
        $('#strong').text($(this).val() || 'slug');
      })
      $('tbody').on('click','.btn-del',function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          url:'./categories/cateDel.php',
          data:{id:id},
          success: function(info){
            render();
          }
        })
      })
      $('tbody').on('click','.btn-edit', function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          url:'./categories/cateGetOne.php',
          data:{id:id},
          dataType:'json',
          success: function(info) {
            //console.log(info);
            $('#name').val(info.name);
            $('#slug').val(info.slug);
            $('#strong').text(info.slug);
            $('#id').val(info.id)
            $('.btn-add').hide();
            $('.btn-update').show()
          }
        })
      })
      $('.btn-update').click(function(){
        //console.log(123);
        var formData = $('#form').serialize();
        $.ajax({
          url:'./categories/cateUpdate.php',
          data:formData,
          success:function(info){
            //console.log(info);  
            render();
            $('#form')[0].reset();
            $('.btn-add').show();
            $('.btn-update').hide();
          }
        })
      })
    })
  </script>
  <script type="text/template" id="tmp">
  {{each list v i}}
    <tr>
      <td class="text-center"><input type="checkbox"></td>
      <td>{{ v.name }}</td>
      <td>{{ v.slug }}</td>
      <td class="text-center" data-id="{{ v.id }}">
        <a href="javascript:;" class="btn btn-info btn-xs btn-edit">编辑</a>
        <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
      </td>
    </tr>
  {{/each}}
  </script>
</body>
</html>
