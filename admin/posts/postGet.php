<?php
    include_once '../../fn.php';
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];
    $start = ($page - 1)*$pageSize;
    $sql = "select posts.*,users.nickname,categories.name from posts
            join users on posts.user_id = users.id
            join categories on posts.category_id = categories.id
            order by posts.id desc
            limit $start, $pageSize";
    $data = my_query($sql);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    echo json_encode($data);
?>