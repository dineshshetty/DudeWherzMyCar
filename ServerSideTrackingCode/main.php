<!DOCTYPE HTML> 
<html>
<head>
</head>
<body> 

<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$correctpass="abc";

if($_POST['Password'] == $correctpass)

{

$stmt = $conn->prepare("TRUNCATE TABLE tbllocations");

if (!$stmt->execute()) {
  echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}

}
}

?>

<h2>Delete All Locations</h2>
<form method="post" > 
   <input type="submit" name="submit" value="Submit"> 
</form>


</body>
</html>
