<?php 
    include_once '../../fn.php';
    $page = $_GET['page'];
    $pageSize = $_GET['pageSize'];

    $start =  ($page - 1) * $pageSize;
    
    $sql = "select comments.*,posts.title from comments 
    join posts on comments.post_id = posts.id order by id limit $start,$pageSize";
    $data = my_query($sql);
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';

    echo json_encode($data);
?>
