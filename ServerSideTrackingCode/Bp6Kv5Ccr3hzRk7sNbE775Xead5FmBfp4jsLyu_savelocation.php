<!--This file handles the save location and monitoring functionality>

<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


require_once('conn.php');

function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

$stmt2 = $conn->prepare("SELECT * FROM tbllocations WHERE id=(SELECT MAX(id) AS max FROM tbllocations)");
$stmt2->execute();
$stmt2->bind_result($id0, $latitude0,$longitude0,$date0,$time0);
while ($stmt2->fetch()) {
}

//printf("OLD:%s\n%s\n%s\n%s\n%s\n", $id0, $latitude0,$longitude0,$date0,$time0);

$stmt2->close();
$data = $_GET["location"].PHP_EOL;
$myArray = explode('||', $data);
$locations=$myArray[0];

$loc= explode(",",$locations);
$latitude=$loc[0];
$longitude=$loc[1];

$date=$myArray[1];
$time=$myArray[2];

$stmt = $conn->prepare("INSERT INTO `tbllocations` (`latitude`,`longitude`,`date`,`time`) VALUES (?,?,?,?)");
$stmt->bind_param("ssss",$latitude, $longitude, $date, $time);

if (!$stmt->execute()) {
 //   echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
}
//printf("New:\n%s\n%s\n%s\n%s\n%s\n", $id, $latitude,$longitude,$date,$time);

$stmt->close();
$movement=distance($latitude0, $longitude0, $latitude, $longitude, "M");
if ($movement>0.1)
{
echo "\n"."Car moved ".$movement." miles";

$stmt5 = "SELECT * FROM `tblcounter` where id=1";
$result5 = mysqli_query($conn, $stmt5);

if (mysqli_num_rows($result5) > 0) {
    // output data of each row
    while($row5 = mysqli_fetch_assoc($result5)) {
        $counter=$row5["counter"];
    }
} else {
    echo "0 results";
}

if ($counter==0)
{
echo "sms sent";
//Todo - Add code for SMS sending using Twilio

$stmt3 = $conn->prepare("UPDATE tblcounter SET counter='1'");
$stmt3->execute();

$stmt3->close();
} else {echo "\n"."SMS not sent";}


} else {echo "\n"."Car not moved";}

?>
