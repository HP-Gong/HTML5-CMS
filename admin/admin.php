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
   
$result= "";
		
if(isset($_POST['submit_update'])){

$myname = filter_input(INPUT_POST, 'myname', FILTER_SANITIZE_STRING);
$myname = strip_tags(trim($_POST['myname']));
$uname = filter_input(INPUT_POST, 'uname', FILTER_SANITIZE_STRING);
$uname = strip_tags(trim($_POST['uname']));
$upassword = filter_input(INPUT_POST, 'upassword', FILTER_SANITIZE_STRING);
$upassword = strip_tags(trim($_POST['upassword']));

global $conn;
$sql1 = "UPDATE myadmin SET myname='$myname', uname='$uname', upassword='$upassword'";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindValue(':myname', $myname, PDO::PARAM_STR);
$stmt1->bindValue(':uname', $uname, PDO::PARAM_STR);
$stmt1->bindValue(':upassword', $upassword, PDO::PARAM_STR);
$stmt1->execute(array(":myname" => $myname, ":uname" => $uname, ":upassword" => $upassword));

$result = '<div class="alert alert-success">Admin is Updated!</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="coreui/img/favicon.png"> 
        <title>Admin Panel</title>
        <!-- Icons -->
        <link href="coreui/css/font-awesome.min.css" rel="stylesheet">
        <link href="coreui/css/simple-line-icons.css" rel="stylesheet">
        <!-- Main styles for this application -->
        <link href="coreui/css/style.css" rel="stylesheet">
</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
<?php include 'include/header.php'; ?>
     <div class="app-body">
     <?php include 'include/sidebar.php'; ?>
      <!-- Main content -->
        <main class="main">
            <br>
            <div class="container-fluid">
                <div id="ui-view">
                       <div class="col-lg-12"> <!-- col-lg-12 -->
                            <div class="card"> <!-- card -->
                                 <!-- card-header -->
                                 <div class="card-header">
                                    <i class="fa fa-user"></i> Admin Section
                                </div>
                               <!-- /card-header -->
                               <!-- card-block -->
                               <div class="card-block">
                               <?php echo $result; ?>
                               <?php
								global $conn;
								if(isset($_GET['edit_id'])){
								$edit_id = $_GET['edit_id'];
								$stmt2 = $conn->query("SELECT * FROM myadmin WHERE u_id='".$edit_id."'");
								while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {?>
                                    <form  action="admin.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="myname">Full Name</label>
                                            <div class="col-md-9">
                                                <input type="text" id="myname" name="myname" class="form-control" value="<?php echo $row['myname']; ?>" required> 
                                            </div>
                                           </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="uname">Username</label>
                                            <div class="col-md-9">
                                                <input type="text" id="uname" name="uname" class="form-control" value="<?php echo $row['uname']; ?>" required> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-3 form-control-label" for="upassword">Password</label>
                                            <div class="col-md-9">
                                                <input type="text" id="upassword" name="upassword" class="form-control" value="<?php echo $row['upassword']; ?>" required> 
                                            </div>
                                        </div>
                                    <div class="form-group row">
                                     <div class="col-md-9">
                                    <button type="submit" id="submit_update" name="submit_update" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                                    </div> 
                                    </div> 
                                    </form>
                               </div> <!-- /card block -->
                               <?php }} ?> 
                                <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Full Name</th>
                                                <th>Username</th>
                                                <th>Password</th>
                                                <th>Date</th>
                                                <th>Edit</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php 
                                          global $conn;
                                          $sql = "SELECT * FROM myadmin";
                                          $result = $conn->query($sql);
                                          while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                          echo '<tr>
                                          <td>'.$row['myname'].'</td>
                                          <td>'.$row['uname'].'</td>
                                          <td>'.$row['upassword'].'</td>
                                          <td>'.$row['date'].'</td>
                                          <td><a href="admin.php?edit_id='.$row['u_id'].'" class="btn btn-warning btn-sm">Edit</a></td>
                                          </tr>';
                                          }
                                          ?>
                                        </tbody>
                                    </table>
                                </div> <!-- /card -->
                            </div><!-- /col-lg-12 -->
                </div>
            </div>
            <!-- /.conainer-fluid -->
        </main>
 </div>
        
<?php include 'include/footer.php'; ?>   
  
        <!-- jQuery scripts for this application -->
        <script type="text/javascript" src="coreui/js/libs/jquery.min.js"></script>
        <script type="text/javascript" src="coreui/js/libs/tether.min.js"></script>
        <script type="text/javascript" src="coreui/js/libs/bootstrap.min.js"></script>
        <script type="text/javascript" src="coreui/js/libs/pace.min.js"></script>
        <script type="text/javascript" src="coreui/js/app.js"></script>
        <script type="text/javascript" src="coreui/js/views/main.js"></script>
    </body>
</html>
