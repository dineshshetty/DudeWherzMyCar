<!DOCTYPE HTML>
<html>
<head>
</head>
<body>

<!--This page handles the delete all locations from DB operation>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$password = $_POST['Password'];

$sql = "SELECT * FROM tblhashing  WHERE id=(SELECT MAX(id) AS max FROM tblhashing)";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    $thehash=$row['hashAndSalt'];
  }
} else {
    echo "0 results";
}
$result->close();

$hash = substr( $thehash, 0, 60 );
if (password_verify($password,$hash)) {
//Password matches, so create the session
  $stmt = $conn->prepare("TRUNCATE TABLE tbllocations");
  if ($stmt->execute()) {
  echo "<script type='text/javascript'>alert('Locations Cleared');</script>";
  }

}else{
echo  "The username or password do not match";
}
$stmt->close();
}

?>

<form method="post">
      password: <input type="text" name="Password"><br>
      <input type="Submit" name="Form1_Submit" value="Delete">
</form>

</body>
</html>

