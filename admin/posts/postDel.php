<?php 
    include_once '../../fn.php';
    $id = $_GET['id'];
    $sql1 = "delete from posts where id in ($id)";
    my_exec($sql1);
    
    $sql = "select count(*) as total from posts 
            join users on posts.user_id = users.id
            join categories on posts.category_id = categories.id";
    $data = my_query($sql)[0];

    echo json_encode($data);
?>