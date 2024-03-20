<?php
include 'db.php';

// Proses inset data
if(isset($_POST['add'])){
    $q_insert = "INSERT INTO task (task_lable, task_status) VALUE (
        '".$_POST['task']."',
        'open'
    )";

    $q_insert = "INSERT INTO task (task_lable, task_status) VALUES (
        '".mysqli_real_escape_string($conn, $_POST['task'])."',
        'open'
        )";

    $run_q_insert = mysqli_query($conn, $q_insert);
    if($run_q_insert){
        header('Refresh:0; url=index.php');
    }
    // $run_q_insert = mysqli_query($conn, $q_insert);

    // if($run_q_insert) {
    //     header('Refresh:0; url-index.php');
    // }
    // if(!$run_q_insert){
    //     echo 'Error: ' . mysqli_error($conn);
    // } else {
    //     header('Refresh:0 url-index.php');
    // }
}

//show data
$q_select = "SELECT * FROM task ORDER BY task_id DESC";
$run_q_select = mysqli_query($conn, $q_select);

//delete data
if(isset($_GET['delete'])){
    $q_delete ="DELETE FROM task WHERE task_id = '".$_GET['delete']."'";
    $run_q_delete = mysqli_query($conn, $q_delete);
    header('Refresh:0; url=index.php');
}

//update status
if(isset($_GET['done'])){
    $status = 'close';

    if($_GET['status'] == 'open'){
        $status='close';
    }else{
        $status='open';
    }

    $q_update = "UPDATE task SET task_status = '".$status."' WHERE task_id = '".$_GET['done']."'";
    $run_q_update = mysqli_query($conn, $q_update);
    header('Refresh:0; url=index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="title">
            <i class='bx bx-sun'></i>
            <span>To Do List</span>
        </div>

        <div class="description">
            <? date("1, d M Y")?>

        </div>
        </div>


        <!-- Content -->
        <div class="content">
        <div class="card">
            <form action="" method="post">
                <input name="task" type="text" class="input-control" placeholder="Add Task">
                <div class="text-right">
                    <button type="submit" name="add">Add</button>
                </div>
            </form>
        </div>
        <!-- Tugas -->
        <?php
        if(mysqli_num_rows($run_q_select) > 0){
            while($r = mysqli_fetch_array($run_q_select)){

        
        ?>
        <div class="card">
            <div class="task-item <?= $r['task_status'] == 'close' ? 'done' :''?>">
                <div>
                    <input type="checkbox" onclick="window.location.href= '?done=<?=$r['task_id']?>&status=<?=$r['task_status']?>'"<?= $r['task_status'] == 'close' ? 'checked': ''?>>
                    <span><?= $r['task_lable']?></span>
                </div>
                <div>
                <a href="edit.php?id=<?=$r['task_id']?>" class="edit-task" title="edit"><i class='bx bx-edit' ></i></a>
                <a href="?delete=<?= $r['task_id']?>" class="delete-task" title="remove" onclick="return confirm('Are you sure?')"><i class='bx bx-trash' ></i></a>
                </div>
            </div>
        </div>

    <?php } } else { ?> 
        <div>Belum ada data</div>

    <?php } ?>

        <!-- <div class="card">
            <div class="task-item">
                <div>
                    <input type="checkbox">
                    <span>Makan Pagi</span>
                </div>
                <div>
                <a href="" class="edit-task"><i class='bx bx-edit' ></i></a>
                <a href="" class="delete-task"><i class='bx bx-trash' ></i></a>
                </div>
            </div>
        </div> -->
        
        </div>
    </div>
</body>
</html>