<?php
    include_once '../../fn.php';
    $info = $_POST;

    $sql = "select * from options where id = 9";
    $data = my_query($sql)[0]['value'];
    $arr = json_decode($data,true);
    $arr[]= $info;
    $str = json_encode($arr,JSON_UNESCAPED_UNICODE);
    $sql1= "update options set value='$str' where id=9";
    my_exec($sql1);
?>