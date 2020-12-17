<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- jQuery -->
    <script src="http://code.jquery.com/jquery-1.9.0rc1.js"></script>
    <script src="http://code.jquery.com/jquery-migrate-1.0.0rc1.js"></script>
    <!-- bs5 -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <!-- dataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" > 
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <!-- markcell tabledit -->
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading">Sample Data</div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="sample_data">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Gender</th>
                            </tr>   
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<script type="text/javascript">
    var dataTable = $('#sample_data').DataTable({
        "processing": true,//處理中畫面
        "serverSide": true,
        "order": [],// 資料排序許可？
        "ajax":{
            url: "fetch.php",
            type: "POST",
        },
    });
    console.log(dataTable);

    $('#sample_data').on('draw.dt', function(){
        $('#sample_data').Tabledit({
            url:'action.php',// send request
            dataType: 'json',// receive data in JSON format
            columns:{
                identifier: [0, 'id'],// use this ID value for edit or delete mySQL
                editable:[// 決定哪些欄位可以修改，按下 修改 跳出文字框或下拉選單
                    [1, 'first_name'], 
                    [2, 'last_name'], 
                    [3, 'gender', '{ "1":"Male", "2":"Female" }']
                ]
            },
            restoreButton: false,
            onSuccess: function(data, textStatus, jqXHR){
                if(data.action == 'delete'){
                    $('#' . data.id).remove()
                    $('#sample_data').DataTable().ajax.reload()// 重新顯示table，但不重整頁面
                }
            }
        })
    })
</script>