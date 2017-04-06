<?php 

	$conf = ["db" =>
					[
						"server"   =>  "localhost",
						"database" =>   "attendance",
						"user"     =>   "root",
						"password" =>   "123456"
					]				

	];

@mysql_connect($conf["db"]["server"], $conf["db"]["user"],$conf["db"]["password"]) or die (mysql_error());
mysql_select_db($conf["db"]["database"]) or die (mysql_error()) ;

$form_row = [
				'id'       => '',
				'name'     => '',
				'gender'   => '',
				'address'  => '',
				'phone'    => '',
];


if(!empty($_POST))
{
	$id     = mysql_real_escape_string($_POST['id']);
	$name   = mysql_real_escape_string($_POST['name']);
	$gender = mysql_real_escape_string($_POST['gender']);
	$address= mysql_real_escape_string($_POST['address']);
	$phone  = mysql_real_escape_string($_POST['phone']);



if(empty($id))
{
	$id = 'Null';
}

else
{
	$id = '"' . $id . '"';
}

	$sql = 'INSERT INTO `student` VALUES(' . $id .  ', "' . $name . '", "' . $gender . '", "' . $address . '", "' . $phone . '")';
	mysql_query($sql) or die(mysql_error());

}

$sql = 'SELECT * FROM `student`';
$rsa = mysql_query($sql);

$grid =[];

while($row = mysql_fetch_assoc($rsa))
{
	$grid[] = $row;
}


 ?>




<!DOCTYPE html>
<html>
<head>
	<title>Attendance System</title>

<style type="text/css">
	
body{
	background-color: #C0C0C0;
	text-align: center;
}

</style>
</head>
<body>

		
				<form action="" method= "post">
		<table>

				<tr>
						<td>Id</td>
						<td><input type="text" name="id" value="<?php  echo $form_row['id']; ?>"></td>
				</tr>

				<tr>
						<td>Name</td>
						<td><input type="text" name="name" value="<?php echo $form_row['name']; ?>"></td>
				</tr>

				<tr >
						<td >Gender</td>
						<td>
							<select name = "gender">  
								<option value = "" > -- SELECT GENDER -- </option>
								<option value = "Male">    Male </option>
								<option value = "Female"> Female </option>
							</select>
						</td>
				</tr>

				<tr>
						<td>Address</td>
						<td><textarea name="address"><?php echo $form_row['address']; ?></textarea></td>
				</tr>
					
				<tr>
						<td>Phone</td>
						<td><input type="text" name="phone"   value="<?php echo $form_row['phone']; ?>"></td>
				</tr>

				<tr>
						<td><input type="submit" value = "Submit" ></td>
				</tr>



		</table>
<br> <br>

		<table border = "" width="500" align="center">
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Gender</th>
				<th>Address</th>
				<th>Phone</th>
			</tr>

			<?php foreach ($grid as $row) {
				
				echo '<tr>' . "\r\n";
				echo '<td>' . $row['id']      . '</td>' . "\r\n";
				echo '<td>' . $row['name']    . '</td>' . "\r\n";
				echo '<td>' . $row['gender']  . '</td>' . "\r\n";
				echo '<td>' . $row['address'] . '</td>' . "\r\n";
				echo '<td>' . $row['phone']   . '</td>' . "\r\n";

				echo '</tr>' . "\r\n";



			} ?>



		</table>



</body>
</html>