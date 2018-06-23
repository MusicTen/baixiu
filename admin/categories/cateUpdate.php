<?php
    include_once '../../fn.php';
    // echo '<pre>';
    // print_r($_GET);
    // echo '</pre>';
    $id = $_GET['id'];
    $name = $_GET['name'];
    $slug = $_GET['slug'];
    $sql = "update categories set name = '$name' , slug= '$slug' where id = $id";
    my_exec($sql);
?>