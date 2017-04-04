# Codes
<?php

// CRUD

###########################################################################
$config = [
			"db" => [
						"server" => "localhost",
						"database" => "test",
						"user" => "root",
						"password" => "123456"
					]
		];
###########################################################################

@mysql_connect($config["db"]["server"], $config["db"]["user"], $config["db"]["password"]) or die(mysql_error());
mysql_select_db($config["db"]["database"]) or die(mysql_error());

$form_row = [
	'id' => '',
	'name' => '',
	'age' => '',
];

###########################################################################
// Update
###########################################################################

if ( array_key_exists('action', $_GET) && $_GET['action'] == 'edit')
{
	$id = mysql_real_escape_string($_GET['id']);

	if (!empty($_POST))
	{
		$name = mysql_real_escape_string($_POST['name']);
		$age = mysql_real_escape_string($_POST['age']);

		mysql_query('UPDATE `student` set `name`="' . $name . '", `age`="' . $age . '" WHERE `id`=' . $id);

		header('Location: http://localhost/First/Student.php');
	}

	$rsa = mysql_query('SELECT * FROM `student` WHERE `id`=' . $id);
	$form_row = mysql_fetch_assoc($rsa);
}
###########################################################################

###########################################################################
// Delete
###########################################################################
if ( array_key_exists('action', $_GET) && $_GET['action'] == 'delete')
{
	$id = mysql_real_escape_string($_GET['id']);
	mysql_query('DELETE FROM `student` WHERE `id`=' . $id) or die(mysql_error());
	header('Location: http://localhost/First/Student.php');
}
###########################################################################

###########################################################################
// Insertion
###########################################################################
if (!empty($_POST) && !array_key_exists('action', $_GET))
{
	$id = mysql_real_escape_string($_POST['id']);
	$name = mysql_real_escape_string($_POST['name']);
	$age = mysql_real_escape_string($_POST['age']);

	// Checks

	if (empty($id))
	{
		$id = 'NULL';
	}
	else
	{
		$id = '"' . $id . '"';
	}

	$sql = 'INSERT INTO `student` VALUES (' . $id . ',"' . $name . '","' . $age . '")';

	mysql_query($sql) or die(mysql_error());

	header('Location: http://localhost/First/Student.php');
}
###########################################################################


###########################################################################
// Grid
###########################################################################
$sql = 'SELECT * FROM `student`';
$rsa = mysql_query($sql);

$grid = [];

while ($row = mysql_fetch_assoc($rsa))
{
	$grid[] = $row;
}
###########################################################################

?><!DOCTYPE html>
<html>
<head>
	<title>My First Page</title>
</head>
<body>

<form action="" method="post">

<table>
	<tr>
		<td>Id</td>
		<td><input type="text" name="id" value="<?php echo $form_row['id']; ?>" /></td>
	</tr>

	<tr>
		<td>Name</td>
		<td><input type="text" name="name" value="<?php echo $form_row['name']; ?>" /></td>
	</tr>

	<tr>
		<td>Age</td>
		<td><input type="text" name="age" value="<?php echo $form_row['age']; ?>" /></td>
	</tr>

	<tr>
		<td></td>
		<td><input type="submit" value="<?php echo empty($form_row['id']) ? 'Add':'Update'; ?>" /></td>
	</tr>

</table>


<table width="400">
	<tr>
		<th>Id</td>
		<th>Name</td>
		<th>Age</td>
		<th>Actions</td>
	</tr>
<?php foreach ($grid as $row)
{
	echo '	<tr>' . "\r\n";
	echo '		<td>' . $row['id'] . '</td>' . "\r\n";
	echo '		<td>' . $row['name'] . '</td>' . "\r\n";
	echo '		<td>' . $row['age'] . '</td>' . "\r\n";
	echo '		<td><a href="?action=edit&id=' . $row['id'] . '">Edit</a> <a href="?action=delete&id=' . $row['id'] . '">Delete</a></td>' . "\r\n";
	echo '	</tr>' . "\r\n";
}
?>
</table>

</body>
</html>
