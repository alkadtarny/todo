<?php
	include 'koneksi.php';

	if(isset($_POST['add'])){
		$task = $_POST['task'];
		$deadline = $_POST['deadline']; // Capture the deadline
	
		$q_insert = "INSERT INTO tasks (tasklabel, taskstatus, deadline) VALUES (
			'$task', 
			'open',
			'$deadline'
		)";
		$run_q_insert = mysqli_query($con, $q_insert);
	
		if($run_q_insert){
			header('Refresh:0; url=index.php');
		}
	}


	$q_select = "select * from tasks order by taskid desc";
	$run_q_select = mysqli_query($con, $q_select);


	if(isset($_GET['delete'])){

		$q_delete = "delete from tasks where taskid = '".$_GET['delete']."' ";
		$run_q_delete = mysqli_query($con, $q_delete);

		header('Refresh:0; url=index.php');

	}


	if(isset($_GET['done'])){
		$status = 'close';

		if($_GET['status'] == 'open'){
			$status = 'close';
		}else{
			$status = 'open';
		}

		$q_update = "update tasks set taskstatus = '".$status."' where taskid = '".$_GET['done']."' ";
		$run_q_update = mysqli_query($con, $q_update);

		header('Refresh:0; url=index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>To Do List</title>
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
		* {
			padding:0;
			margin:0;
			box-sizing: border-box;
		}
		body {
			font-family: 'Roboto', sans-serif;
			background: #159957; 
    		background: -webkit-linear-gradient(to right, #155799, #159957);  
    		background: linear-gradient(to right, #155799, #159957);  

		}
		.container {
			width: 1000px;
			height: 100vh;
			margin:0 auto;
		}
		.header {
			padding: 15px;
			color: #fff;
		}
		.logout-btn {
			background: rgba(18, 61, 253, 0.808);
			color: #fff;
			padding: 0.5rem 1rem;
			border: none;
			cursor: pointer;
			border-radius: 3px;
			text-decoration: none;
			font-size: 1rem;
			position: absolute;
    		top: 40px;
    		right: 230px;
		}
		.content {
			padding: 15px;
		}
		.card {
			color: black;
			background-color: #fff;
			padding:15px;
			border-radius: 5px;
			margin-bottom: 10px;
		}
		.input-control {
			width:100%;
			display: block;
			padding:0.5rem;
			font-size: 1rem;
			margin-bottom: 10px;
		}
		input[type="datetime-local"] {
    		width: 100%;
    		padding: 0.5rem;
    		font-size: 1rem;
    		margin-bottom: 10px;
		}
		small {
    		color: #666;
		}
		.text-right {
			text-align: right;
		}
		button {
			padding:0.5rem 1rem;
			font-size: 1rem;
			cursor: pointer;
			background: rgba(18, 61, 253, 0.808);
			color: #fff;
			border: none;
			border-radius: 3px;
			text-decoration: none;
		}
		.task-item {
			display: flex;
			justify-content: space-between;
		}
		.text-orange {
			color: orange;
		}
		.text-red {
			color: red;
		}
		.task-item.done span {
			text-decoration: line-through;
			color: #ccc;
		}
		@media (max-width: 768px){
			.container {
				width: 100%;
			}
		}
	</style>
</head>
<body>

	<div class="container">
		
		<div class="header">
			
		<div class="header">
			<div class="title">
				<i class='bx bx-task'></i>
				<span>To Do List</span>
			</div>
			<div class="description">
				<?= date("l, d M Y") ?>
			</div>
			<a href="logout.php" class="logout-btn">Logout</a>
		</div>


		<div class="content">
			
			<div class="card">
				
				<form action="" method="post">

					<input type="text" name="task" class="input-control" placeholder="Tambah Tugas" autocomplete="off" required>
								
					<label for="deadline">Deadline:</label>
    					<input type="datetime-local" name="deadline" class="input-control" required>

					<div class="text-right">
						<button type="submit" name="add">Tambah</button> 
					</div>

				</form>

			</div>


			<?php
if(mysqli_num_rows($run_q_select) > 0){
    while($r = mysqli_fetch_array($run_q_select)){
?>
<div class="card">
    <div class="task-item <?= $r['taskstatus'] == 'close' ? 'done':'' ?>">
        <div>
            <input type="checkbox" onclick="window.location.href = '?done=<?= $r['taskid'] ?>&status=<?= $r['taskstatus'] ?>'" <?= $r['taskstatus'] == 'close' ? 'checked':'' ?>>
            <span><?= $r['tasklabel'] ?></span>
            <br>
            <small>Deadline: <?= date("d M Y ", strtotime($r['deadline'])) ?></small>
        </div>
        <div>
            <a href="edit.php?id=<?= $r['taskid'] ?>" class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
            <a href="?delete=<?= $r['taskid'] ?>" class="text-red" title="Remove" onclick="return confirm('Apakah kamu yakin?')"><i class="bx bx-trash"></i></a>
        </div>
    </div>
</div>
<?php }} else { ?>
    <div class="card">Belum ada tugas</div>
<?php } ?>

		</div>

	</div>

</body>
</html>