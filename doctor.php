<?php 
	
	$config = ["db" => 
						[ 
						"server" => "localhost",
						"database" => "doctor",
						"user"   => "root",
						"password" => "123456"
						]

			];

	@mysql_connect( $config["db"]["server"], $config["db"]["user"], $config["db"]["password"] ) or die (mysql_error()) ;
	mysql_select_db($config["db"]["database"]) or die(mysql_error());

	$form_row = [
         
         'id'   =>  '',
         'name' =>  '',

	];

    ##################################################################################################################
	#Update Doctors 
	##################################################################################################################

	if(array_key_exists('action', $_GET) && $_GET['action'] == "edit")
	{
		$id = mysql_real_escape_string($_GET['id']);

		if(!empty($_POST))
		{
			$name = mysql_real_escape_string($_POST['name']);
		

		mysql_query('UPDATE `doctors` set `name`= "' . $name .'" WHERE `id`=' .$id); 
		}

		$rsa = mysql_query ('SELECT * FROM `doctors` WHERE `id`=' . $id);
		$form_row = mysql_fetch_assoc($rsa);
	
	}

    ##################################################################################################################
	#Delete Doctor
	##################################################################################################################

	if(array_key_exists('action', $_GET) && $_GET['action'] == "delete")
	{
		$id = mysql_real_escape_string($_GET['id']);

		mysql_query('DELETE FROM `doctors` WHERE `id`=' . $id);
	}



	##################################################################################################################
	#Insert Doctors 
	##################################################################################################################

	if(!empty($_POST) && !array_key_exists('action', $_GET) )
	{
		$id = mysql_real_escape_string($_POST['id']);
		$name = mysql_real_escape_string($_POST['name']);

		if(empty($id))
		{
			$id = 'null';
		}
		else
		{
			$id = '"' . $id . '"';
		}

		$sql = 'INSERT INTO `doctors` VALUES(' . $id .', "' . $name .'")';
		mysql_query($sql);
	}

	##################################################################################################################
	#Grid
	##################################################################################################################


	$sql = 'SELECT * FROM `doctors`';
	$rsa = mysql_query($sql);

	$grid = [];

	while($row = mysql_fetch_assoc($rsa))
	{
		$grid[] = $row;
	}


    ##################################################################################################################
	#HTML 
	##################################################################################################################


 ?><!DOCTYPE html>
 <html>
 <head>
 	<title> Doctors </title>
 	<link rel="stylesheet" type="text/css" href="style.css">

 </head>
 <body>
  
 		<form action="" method="post">
 			<table >
 				<tr>
 					<td>Id</td>
 					<td><input type="text" name="id" value="<?php echo $form_row['id']; ?>"    ></td>
 				</tr>

 				<tr>
 					<td>Doctor Name</td>
 					<td><input type="text" name="name" value="<?php echo $form_row['name']; ?>" ></td>
 				</tr>
 				<tr>
 				<td><input type="submit" value="<?php echo  empty($form_row['id']) ? 'Add' : 'Update'; ?>"></td>
 				</tr>

 			</table>
 		</form>

<table border = "1" width="500" align = "center" >
		<tr>
			<th>Id</th>
			<th>Doctor Name</th>
			<th>Actions</th>
		</tr>

		<?php foreach ($grid as $row) {

			echo '<tr>' . "\r\n";
			echo '<td>' . $row['id'] .  '</td>'  . "\r\n"; 
			echo '<td>' . $row['name'] . '</td>' . "\r\n" ;
			
			echo '<td><a href="?action=edit&id=' . $row['id'] . '">  Edit </a> <a href="?action=delete&id=' . $row['id'] . '">  Delete </a></td>' . "\r\n";
		} ?>

</table>

 </body>
 </html>
