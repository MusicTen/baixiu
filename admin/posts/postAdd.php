<?php
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // echo '<pre>';
    // print_r($_FILES);
    // echo '</pre>';
    include_once '../../fn.php';

    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    $feature = '';

    session_start();
    $userid = $_SESSION['user_id'];

    $file = $_FILES['feature'];
    if($file['error'] ===0){
        $ftmp = $file['tmp_name'];
        $ext = strrchr($file['name'],'.');
        $newName = './uploads/'.time().rand(100,999).$ext;
        move_uploaded_file($ftmp,'../../'.$newName);
        $feature = $newName;
    }

    $sql = "insert into posts (title, slug, feature, created, content, status, user_id, category_id) 
    values ('$title', '$slug', '$feature', '$created', '$content', '$status', $userid, $category)";
    
    my_exec($sql);
    header('location:../posts.php');
?>