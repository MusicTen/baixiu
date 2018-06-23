<?php 
  include_once '../fn.php';
  isLogin();
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm btn-dels" href="javascript:;" style="display: none">批量删除</a>
        <!-- <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul> -->
        <div class="page-box pull-right"></div>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input class="th-chk" type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
  <!-- 添加页面的标记 -->
  <?php $page = "post" ?>
  <!-- 引入aside -->
  <?php include_once './inc/aside.php' ?>

  <?php include_once './inc/edit.php' ?>

  <script src="../assets/vendors/jquery/jquery.js"></script>
  <script src="../assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../assets/vendors/template/template-web.js"></script>
  <script src="../assets/vendors/pagination/jquery.pagination.js"></script>
  <script src="../assets/vendors/moment/moment.js"></script>
  <script src="../assets/vendors/wangEditor/wangEditor.min.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
      //草稿（drafted）/ 已发布（published）/ 回收站（trashed）
      var state= {
       drafted:'草稿',
       published:'已发布',
       trashed:'回收站'
      }
      //表格渲染
      var current = 1;
      function render(page,pageSize){
        $.ajax({
          url:'./posts/postGet.php',
          data:{
            page:page||1,
            pageSize:pageSize||10
          },
          dataType: 'json',
          success:function(info){
            console.log(info);
            var obj = {
              list:info,
              state : state
            }
            $('tbody').html(template('tmp',obj));
          }
        })
      }
      render();
      //分页功能
      function setPage(page) {
        $.ajax({
          url:'./posts/postTotal.php',
          dataType:'json',
          success:function(info) {
            $('.page-box').pagination(info.total,{
              prev_text: '上一夜',
              next_text: '下一夜',
              current_page: page - 1 || 0,
              num_display_entries: 7, //连续主体个数
              load_first_page: false, //初始化完成回调函数不执行
              callback: function (index) { //当前页码索引值
                //渲染当前页
                render(index + 1);
                current = index +1; //记录当前页
              }
            })
          }
        })
      }
      setPage();
      //删除功能
      $('tbody').on('click','.btn-del',function(){
        var id = $(this).parent().attr('data-id');
        console.log(id);
        $.ajax({
          url:'./posts/postDel.php',
          data: {id:id},
          dataType:'json',
          success:function(info){
            var maxPage = Math.ceil(info.total/10);
            if(current>maxPage){
              current = maxPage;
            }
            render(current);
            setPage(current);
          }
        })
      })
      //全选
      $('.th-chk').change(function(){
        if($(this).prop('checked')){
          $('.tb-chk').prop('checked',true);
          $('.btn-dels').show();
        } else {
          $('.tb-chk').prop('checked',false);
          $('.btn-dels').hide();
        }
      })
      $('tbody').on('change','.tb-chk',function(){
        if($('.tb-chk:checked').length == $('.tb-chk').length){
          $('.th-chk').prop('checked',true);
        } else {
          $('.th-chk').prop('checked',false);
        }
        if($('.tb-chk:checked').length > 0){
          $('.btn-dels').show();
        } else {
          $('.btn-dels').hide();
        }
      })
      //获取多选id
      function getId() {
        var arr = [];
        $('.tb-chk:checked').each(function(index,ele){
          var id = $(ele).parent().attr('data-id');
          arr.push(id);
        })
        arr = arr.join();
        return arr;
      }
      $('.btn-dels').click(function(){
        var id = getId();
        //console.log(id);
        $.ajax({
          url:'./posts/postDel.php',
          data: {id:id},
          dataType:'json',
          success: function(info){
            var maxPage = Math.ceil(info.total/10);
            if(current > maxPage){
              current = maxPage;
            }
            render(current);
            setPage(current);
          }
        })
      })
      //设置模态框
      $.ajax({
        url:'./categories/cateGet.php',
        dataType: 'json',
        success: function(info) {
          var obj = {list:info};
          $('#category').html(template('tmp-cate',obj));
        }
      })

      var state = {  //文章的状态  for -in 
        drafted: '草稿',
        published: '已发布',
        trashed: '回收站'
      }
      $('#status').html(template('tmp-state',{obj:state}));
      
      $('#created').val(moment().format('YYYY-MM-DDTHH:mm'));

      $('#slug').on('input',function(){
        $('#strong').text($(this).val()||'slug');
      })
      var E = window.wangEditor;
      var editor = new E('#content-box')
      editor.customConfig.onchange = function (html) {
        $('#content').val(html)
      }
      editor.create();

      $('tbody').on('click','.btn-edit',function(){
        var id = $(this).parent().attr('data-id');
        $.ajax({
          url:'./posts/postGetOne.php',
          data:{id : id},
          dataType:'json',
          success:function(info){
            console.log(info);
            $('#title').val(info.title);
            $('#slug').val(info.slug);
            $('#strong').text(info.slug)
            $('#img').attr('src','../'+info.feature).show();
            $('#content').val(info.content);
            editor.txt.html(info.content);
            $('#category option[value ='+ info.category_id + ']').prop('selected',true);
            $('#stutas option[value = '+ info.status +']').prop('selected',true);
            $('#created').val(moment(info.created).format('YYYY-MM-DDTHH:mm'));
            $('#id').val(info.id);
            $('.edit-box').show();
          }
        })
      })
      $('.btn-update').click(function(){
        var formData = new FormData($('#editForm')[0])
        $.ajax({
          url:'./posts/postUpdate.php',
          type:'post',
          data:formData,
          contentType: false, //告诉$.ajax不要设置请求头
          processData: false, //告诉$.ajax数据不用转成字符串的格式 name=zs&age=18
          success:function(info) {
            $('.edit-box').hide();
            render(current);
          }
        })
      })
      $('.btn-cancel').click(function(){
        $('.edit-box').hide();
      })
    })
  </script>
  <script type="text/template" id="tmp">
    {{ each list v i }}
      <tr>
        <td class="text-center" data-id="{{ v.id }}"><input class="tb-chk" type="checkbox"></td>
        <td>{{ v.title }}</td>
        <td>{{ v.nickname }}</td>
        <td>{{ v.name }}</td>
        <td class="text-center">{{ v.created}}</td>
        <td class="text-center">{{state[v.status]}}</td>
        <td class="text-center" data-id="{{ v.id }}">
          <a href="javascript:;" class="btn btn-default btn-xs btn-edit">编辑</a>
          <a href="javascript:;" class="btn btn-danger btn-xs btn-del">删除</a>
        </td>
      </tr>
    {{ /each }}
  </script>

  <!-- 准备分类下拉列表的模板 -->
  <script type="text/template" id="tmp-cate">
    {{each list v i}}
      <option value="{{v.id}}">{{v.name}}</option>
    {{/each}}
  </script>
    <!-- 文章状态的模板 -->
  <script type="text/template" id="tmp-state">
    {{ each obj v k }}
      <option value="{{k}}">{{v}}</option>
    {{ /each }}
  </script>
</body>
</html>
