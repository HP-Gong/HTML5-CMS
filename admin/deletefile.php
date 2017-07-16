<?php
session_start();
include 'include/db.php';

if (!isset($_SESSION["myname"])){
    header("location: login.php"); 
    exit();
}
$myID = preg_replace('#[^0-9]#i', '', $_SESSION["u_id"]); 
$myname = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["myname"]); 
$upassword = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION["upassword"]); 

global $conn;
$sql = "SELECT count(*) FROM myadmin WHERE u_id='$myID' AND uname='$myname' AND upassword='$upassword'";

if($stmt = $conn->prepare($sql)){

$stmt->execute(array(':u_id' => $myID, ':uname' => $myname, ':upassword' => $upassword));

$number_of_rows = $stmt->fetchColumn(); 

if($number_of_rows == 1){ 
$_SESSION["u_id"]; 
$_SESSION["myname"]; 
$_SESSION["upassword"]; 
exit();
}
}

if(isset($_REQUEST['del_id'])){
global $conn;
$del_id = $_REQUEST['del_id'];
$stmt = $conn->query("SELECT * FROM posts WHERE p_id='".$del_id."'");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$photos = $row['photos'];
unlink("../images/".$photos);
$sql = "DELETE FROM posts WHERE p_id = '$del_id'";
$stmt1 = $conn->prepare($sql);
$stmt1->execute(array($del_id));
}
}
?>