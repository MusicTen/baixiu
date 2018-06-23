<?php
    include_once '../../fn.php';
    $file = $_FILES['image'];
    if($file['error']===0){
        $info['text']=$_POST['text'];
        $info['link']=$_POST['link'];

        $ftmp = $file['tmp_name'];
        $ext = strrchr($file['name'],'.');
        $newName = './uploads/'.time().rand(100,999).$ext;
        move_uploaded_file($ftmp,'../../'.$newName);
        $info['image'] = $newName;

        $sql ="select * from options where id = 10";
        $data = my_query($sql)[0]['value'];
        $arr= json_decode($data,true);

        $arr[] = $info;
        $str = json_encode($arr,JSON_UNESCAPED_UNICODE);
        $sql1 = "update options set value = '$str' where id =10";
        my_exec($sql1);
    }

?>