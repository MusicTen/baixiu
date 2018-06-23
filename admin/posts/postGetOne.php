<?php
    include_once '../../fn.php';
    $id = $_GET['id'];
    $sql = "select posts.*,users.nickname,categories.name from posts
            join users on posts.user_id = users.id
            join categories on posts.category_id = categories.id
            where posts.id = $id";
    $data = my_query($sql)[0];
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    echo json_encode($data);
?>