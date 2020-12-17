<?php

include "conn_db.php";
$column = array('id', 'first_name', 'last_name', 'gender');
$query = "select * from users";

if(isset($_POST['search']['value'])){// 如果搜尋框有更動就加上下面 sql
    //     .=    類似字串相加的概念
    $query .= 
    '
    where first_name like "%' . $_POST['search']['value'] . '%"
    or last_name like "%' . $_POST['search']['value'] . '%"
    or gender like "%' . $_POST['search']['value'] . '%"
    ';

}


if(isset($_POST['order'])){// 如果按下某個排列欄位就加上 下面 sql
    $query .= ' order by ' . $column[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' ';

}else{
    $query .= ' order by id DESC';
}

$query1 = '';
if($_POST['length']){
    $query1 = ' limit ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connection -> prepare($query);
$statement -> execute();
//print_r($statement);
$number_filter_row = $statement -> rowCount();// 一頁限制筆數

$statement = $connection -> prepare($query . $query1);// 合併 $query, $query1
$statement -> execute();
//print_r($statement);
$result = $statement -> fetchAll();
//print_r($result);
$data = array();
foreach($result as $row){
    $sub_array = array();
    $sub_array[] = $row['id'];
    $sub_array[] = $row['first_name'];
    $sub_array[] = $row['last_name'];
    $sub_array[] = $row['gender'];

    $data[] = $sub_array;
}


function  count_all_data($connection){// 計算總共有幾筆資料
    $query = "select * from users";
    $statement = $connection -> prepare($query);
    $statement -> execute();
    return $statement -> rowCount();

}

$output = array(
    'draw' => intval($_POST['draw']),
    'recordsTotal' => count_all_data($connection),
    'recordsFiltered' => $number_filter_row,
    'data' => $data,

);

echo json_encode($output);
?>