<?php
    include_once '../../fn.php';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $slug = $_POST['slug'];
    $category = $_POST['category'];
    $created = $_POST['created'];
    $status = $_POST['status'];
    $feature = '';

    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    $file = $_FILES['feature'];
    if($file['error'] ===0) {
        $ftmp = $file['tmp_name'];
        $ext = strrchr($file['name'],'.');
        $newName = './uploads/' . time().rand(100,999).$ext;
        move_uploaded_file($ftmp,'../../'.$newName);
        $feature = $newName;


    }
    if (empty($feature)) {
        //没有上传图片
        $sql = "update posts set title = '$title' , slug = '$slug' , content = '$content', category_id = $category,
                status = '$status', created = '$created' where id = $id";
    } else {
        //上传了图片
        $sql = "update posts set title = '$title' , slug = '$slug' , content = '$content', category_id = $category,
                status = '$status', created = '$created', feature = '$feature' where id = $id";
    }
    //echo $sql;
    //执行 
    my_exec($sql);

?>