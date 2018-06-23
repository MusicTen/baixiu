<?php
   include_once '../../fn.php';
   $id = $_GET['id'];
   $sql = "delete from comments where id in ($id)";
   my_exec($sql);
   
   //删除操作执行完了后，给前端返回 数据剩余数据总条数
   $sql = "select count(*) as total from comments join posts on comments.post_id = posts.id";
   $data = my_query($sql)[0];
   // echo '<pre>';
   // print_r($data);
   // echo '</pre>';
   echo json_encode($data);
?>