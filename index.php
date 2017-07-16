<?php include 'include/db.php'; ?>
<!DOCTYPE HTML>
<html>
<head>
<?php 
global $conn;
$sql1 = "SELECT * FROM content";
$result1 = $conn->query($sql1);
$row1 = $result1->fetch(PDO::FETCH_ASSOC);
echo '<title>'.$row1['mtitle'].'</title>';
?>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
<link rel="shortcut icon" href="images/favicon.png">   
<link rel="stylesheet" type="text/css" href="assets/css/main.css" />
<link rel="stylesheet" type="text/css" href="bootstrap/css/font-awesome.css">
<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

<?php include 'include/header.php'; ?>

<!-- Main -->
<div id="main">
<?php 
global $conn;
$sql2 = "SELECT * FROM posts"; //DESC
$result2 = $conn->query($sql2);
while($row2 = $result2->fetch(PDO::FETCH_ASSOC)){
echo '<article id="'.pslugs($row2['ptitle']).'">
<h2 class="major">'.$row2['ptitle'].'</h2>
<span class="image main"><img src="images/'.$row2['photos'].'" alt="" /></span>
<p>'.html_entity_decode($row2['contents']).'</p>
</article>';
}
?>
<?php include 'contact.php'; ?>
</div>

<?php include 'include/footer.php'; ?>
</div>

<!-- BG -->
<div id="bg"></div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/skel.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
