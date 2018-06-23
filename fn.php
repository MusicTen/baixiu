<?php
    //封装php操作数据库函数
    //定义常量
    define('HOST', '127.0.0.1'); // ip地址
    define('UNAME','root'); // 用户名
    define('PWD','root');  // 密码
    define('DB','z_baixiu');// 数据库名

    header('content-type:text/html;charset=utf-8');
    //封装以执行增删改（非查询语句）的方法
    function my_exec($sql){
        $link = @mysqli_connect(HOST,UNAME,PWD,DB);
        if(!$link){
            echo '数据库连接失败';
            return false;
        }
        if(!mysqli_query($link,$sql)){
            echo '操作失败'. mysqli_error($link);
            mysqli_close($link);
            return false;
        }
        mysqli_close($link);
        return true;
    };
    // $sql = "insert into categories (slug,name) values ('aa12','bb')";
    // my_exec($sql);

    //封装以执行增删改（查询语句）的方法
    function my_query($sql){
        $link = @mysqli_connect(HOST,UNAME,PWD,DB);
        if(!$link) {
            echo '数据库连接失败'. mysqli_error($link);
            return false;
        }
        $res = mysqli_query($link,$sql);
        if(!$res || mysqli_num_rows($res) == 0){
            echo '未获取到数据';
            mysqli_close($link);
            return false;
        }
        while( $row = mysqli_fetch_assoc($res) ) {
            $data[] = $row;
        }
        mysqli_close($link);
        return $data;
    };
    //判断用户是否登录,利用session_start()权限控制
    function isLogin() {
        if ( !empty($_COOKIE['PHPSESSID']) ){
            session_start();
            if( empty($_SESSION['user_id'])){
                header('location:./login.php');
                die();
            }
        } else {
            header('location:./login.php');
            die();
        }
    }
?>