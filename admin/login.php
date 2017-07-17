<?php  
session_start();
include("include/db.php");

if(isset($_SESSION["myname"])){
header("location: index.php"); 
exit();
}

if(isset($_POST["uname"]) && isset($_POST["upassword"])){

$myname = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["uname"]); 
$upassword = preg_replace('#[^A-Za-z0-9]#i', '', $_POST["upassword"]); 

$uname = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
$uname = strip_tags(trim($_POST['uname']));
$upassword = filter_input(INPUT_POST, 'upassword', FILTER_SANITIZE_STRING);
$upassword = trim($_POST['upassword']); 

global $conn;

$sql = "SELECT count(*) FROM myadmin WHERE uname='$myname' AND upassword='$upassword' ";

if($stmt = $conn->prepare($sql)){
	
$stmt->execute(array(':uname' => $myname, ':upassword' => $upassword));

$number_of_rows = $stmt->fetchColumn(); 

if($number_of_rows == 0){ 

die('Empty Field / Incorrect username / password combination! Try again <a href="index.php">Click Here</a>');
} else{

$hash = password_hash($upassword, PASSWORD_BCRYPT);

if ($uname && password_verify($upassword, $hash)){

$_SESSION["u_id"] = $id;
$_SESSION["myname"] = $myname;
$_SESSION["upassword"] = $upassword;

header("location: index.php");
exit();
}
} 
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" href="coreui/img/favicon.png"> 
<?php 
global $conn;
$sql = "SELECT * FROM content";
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
echo '<title>'.$row['mtitle'].' Login</title>';
?>
<!-- Icons -->
<link href="coreui/css/font-awesome.min.css" rel="stylesheet">
<link href="coreui/css/simple-line-icons.css" rel="stylesheet">
<!-- Main styles for this application -->
<link href="coreui/css/style.css" rel="stylesheet">
</head>
<body class="align-items-center">
<br>
<div class="app-body">
  <main class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card mx-4">
                    <div class="card-block p-4">
                        <h3>Login</h3>
                        <p class="text-muted">Sign In to your account</p>
                    <form class="form-horizontal" action="#" method="POST" enctype="multipart/form">

                    <div class="input-group mb-3">
                    <span class="input-group-addon"><i class="icon-user"></i></span>
                    <input type="text" name="uname" id="uname" class="form-control" placeholder="Username">                    
                    </div>
                    <br>

                    <div class="input-group mb-3">
                    <span class="input-group-addon"><i class="icon-lock"></i></span>
                    <input type="password" name="upassword" id="upassword" class="form-control" placeholder="Password">

                    </div>
                    <br>
                    
                    <div class="input-group mb-3">
                    <input type="submit" class="btn btn-primary px-4" id="log" value="Login" />
                    </div>
                    
                    </form>
                    </div>
                </div>
            </div>
        </div>
      </div>
   </main> 
</div>

<!-- Bootstrap and necessary plugins -->
<script src="coreui/js/libs/jquery.min.js"></script>
<script src="coreui/js/libs/tether.min.js"></script>
<script src="coreui/js/libs/bootstrap.min.js"></script>
</body>
</html>