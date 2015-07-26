<!--This page handles the connection preferences>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$wgDBserver = 'localhost';
$wgDBuser = 'dns';
$wgDBpassword = 'SomeAwesomePassword';
$wgDBname = 'locationDB';
 

$conn = new mysqli( $wgDBserver, $wgDBuser, $wgDBpassword,$wgDBname );
 
if ( mysqli_connect_errno() ) {
    die( "Failed:" . mysqli_connect_error() );
}
 
