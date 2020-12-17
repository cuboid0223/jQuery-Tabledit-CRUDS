<?php
include 'conn_db.php';

if($_POST['action'] == 'edit'){// 編輯
    $data = array(
        ':first_name' => $_POST['first_name'],
        ':last_name' => $_POST['last_name'],
        ':gender' => $_POST['gender'],
        ':id' => $_POST['id'],
        
    );
    $query = "
    update users set
    first_name = :first_name,
    last_name  = :last_name,
    gender = :gender
    where id = :id;
    ";
    $statement = $connection -> prepare($query);
    $statement -> execute($data);
    echo json_encode($_POST);
    
}

if($_POST['action'] == 'delete'){// 刪除
    $id = $_POST['id'];
    $query = "delete from users where id = '$id'";
    $statement = $connection -> prepare($query);
    $statement -> execute();
    echo json_encode($_POST);
}



?>