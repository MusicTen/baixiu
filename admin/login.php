<?php
    include_once('../fn.php');    
    if ( !empty($_POST) ) {
      echo '<pre>';
      print_r($_POST);
      echo '</pre>';
      $email = $_POST['email'];
      $password = $_POST['password'];
      // echo $email;
      // echo $password;

      if ( empty($email) || empty($password) ) {
          $msg = '用户名或密码不能为空';
      } else {
          $sql="select * from users where email = '$email'";
          $data = my_query($sql);
          echo '<pre>';
          print_r($data);
          echo '</pre>';
          //判断数据是否找到,即用户名是否存在
          if (!$data) {
            $msg = '用户名不存在';
          } else {
            $data = $data[0];
            //判断密码是否正确
            if ( $data['password'] == $password ) {
              //登录成功做标记
              session_start();
              $_SESSION['user_id'] = $data['id'];
              
              header('location:./index1.php');
            } else {
              $msg = '密码错误';
            }
          }
      }
    }

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
  <div class="login">
    <!-- action如果不写，默认请求当前页面 -->
    <form class="login-wrap" action="" method="post">
      <img class="avatar" src="../assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if ( !empty($msg) ) { ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $msg; ?>
      </div>
      <?php } ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input  id="email" 
                type="email" 
                name="email"
                value = "<?php echo isset($msg) ? $email : '' ?>" 
                class="form-control" 
                placeholder="邮箱" 
                autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input  id="password" 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="密码">
      </div>
      <!-- <a class="btn btn-primary btn-block" href="index.html">登 录</a> -->
      <input class="btn btn-primary btn-block" type="submit" value="登录">
    </form>
  </div>
</body>
</html>
