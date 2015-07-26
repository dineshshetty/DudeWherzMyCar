<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('conn.php');


$stmt = $conn->prepare("SELECT * FROM tbllocations WHERE id=(SELECT MAX(id) AS max FROM tbllocations)");
$stmt->execute(); 
$stmt->bind_result($id, $latitude,$longitude,$date,$time);
while ($stmt->fetch()) {
//printf("%s\n%s\n%s\n%s\n%s\n", $id, $latitude,$longitude,$date,$time);

$coordinates= $latitude.",".$longitude;
$gotolocation= "http://maps.google.com/?daddr={$coordinates}";
header("Location: ".$gotolocation);
}
 
?>
