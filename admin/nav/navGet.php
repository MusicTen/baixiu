<?php
    include_once '../../fn.php';
    $sql="select * from options where id = 9";
    $data = my_query($sql)[0]['value'];
    // echo '<pre>';
    // print_r($data);
    // echo '</pre>';
    echo $data;
?>