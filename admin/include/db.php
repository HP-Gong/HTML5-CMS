<?php
$dbhost = "";
$dbusername = "";
$dbpassword = "";
$dbname = "";

try{
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo $e->getMessage();
}


function pslugs($url){
 
    $url = strtolower($url);
    $url = strip_tags($url);
    $url = stripslashes($url);
    $url = html_entity_decode($url);
    $url = str_replace('\'', '', $url);
    $url = trim(preg_replace('/[^a-z0-9]+/', '-', $url), '-');

    return $url;
}
?> 