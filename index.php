<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<?php
			include_once("tinycms.php");
			$obj = new tinyCMS();
			
			$obj->mysql_host = 'ismaelsobek.db';
			$obj->mysql_username = 'ismaelsobek';
			$obj->mysql_password = '1pandaman';
			$obj->mysql_table = 'testDB';
			
			$obj->connectDB();
			
			if($_POST)
				$obj->write($_POST);
			
			echo ($_GET['admin'] == 1 ) ? $obj->backend() : $obj->frontend();
		?>
	</body>
</html>