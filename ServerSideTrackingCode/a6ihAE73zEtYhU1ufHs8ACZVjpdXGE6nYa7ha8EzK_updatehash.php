<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<!--This file handles the code needed to update server side hash for delete locations>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$password=$_POST["Password"];

$options = [
    'cost' => 12 // the default cost is 10
];
$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
$stmt = $conn->prepare("Update tblhashing SET hashAndSalt=? WHERE id=1");
$stmt->bind_param('s',$hashAndSalt);

echo $sql."\n";       

if($stmt->execute()){
    echo "<script type='text/javascript'>alert('Update Successful');</script>";
    $result = $stmt->get_result();

} else {
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
}
?>

<form method="post">
      password: <input type="text" name="Password"><br>
      <input type="Submit" name="Form1_Submit" value="Generate">
</form>

</body>
</html>
