<?php
    include_once '../../fn.php';
    $id = $_GET['id'];
    $sql = "select * from options where id = 10";
    $data = my_query($sql)[0]['value'];
    // echo $data;
    $arr = json_decode($data,true);
    array_splice($arr,$id,1);
    $str = json_encode($arr,JSON_UNESCAPED_UNICODE);
    $sql1 = "update options set value = '$str' where id = 10";
    my_exec($sql1);
?>