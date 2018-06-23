<?php
    include_once '../../fn.php';
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';
    $id= $_POST['userId'];
    $slug = $_POST['slug'];
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $avatar = '';
    $file = $_FILES['avatar'];
    if($file['error']===0){
        $ftmp=$file['tmp_name'];
        $ext=strrchr($file['name'],'.');
        $newName = './uploads/'.time().rand(100,999).$ext;

        move_uploaded_file($ftmp,'../../'.$newName);
        $avatar = $newName;
    };
    if(empty($avatar)){
        
        $sql="update users set slug='$slug',nickname='$nickname',email='$email',password='$password' where id=$id";
    } else {
        $sql="update users set slug='$slug',nickname='$nickname',email='$email',password='$password',avatar='$avatar' where id=$id";
    };
    my_exec($sql);
?>