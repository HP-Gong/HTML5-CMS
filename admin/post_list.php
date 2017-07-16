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
	
$result = '';

if(isset($_GET['new_status'])){
$new_status = $_GET['new_status'];
$id = $_GET['p_id'];
$sql1 = "Update posts SET status='$new_status' WHERE p_id='$id'";
$stmt1 = $conn->prepare($sql1);
$stmt1->execute(array(":status" => $new_status, ":p_id" => $id));
$result = '<div class="alert alert-success">Posts is Updated!</div>';
}

if(isset($_GET['del_id'])){
$del_id = $_GET['del_id'];
$sql2 = "DELETE FROM posts WHERE p_id = '$del_id'";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute(array($del_id));
$result = '<div class="alert alert-danger">Posts Deleted!</div>';
}

if(isset($_GET['del_img'])){
$del_img = $_GET['del_img'];
$stmt = $conn->query("SELECT * FROM posts WHERE p_id='".$del_img."'");
while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
$photos = $row['photos'];
unlink("../images/".$photos);
header("Location: post_list.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->
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
                                    <i class="fa fa-list"></i>Post Lists
                                </div>
                               <!-- /card-header -->
                               <!-- card-block -->
                                <div class="card-block">
                                <?php echo $result; ?>
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Date</th>
                                                <th>Title</th>
                                                <th>Images</th>
                                                <th>Description</th>
                                                <th>Active Status</th>
                                                <th>Status Button</th>
                                                <th>Edit Post</th>
                                                <th>View Post</th>
                                                <th>Delete Post</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php 
                                          global $conn;
                                          $sql = "SELECT * FROM posts";
                                          $result = $conn->query($sql);
                                          $number = 1;
                                          while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                          $ptitle = preg_replace('/\s+/', '-', $row['ptitle']);
                                          echo '
                                          <tr>
                                          <td>'.$number.'</td>
                                          <td>'.$row['date'].'</td>
                                          <td>'.$row['ptitle'].'</td>               
										  <td><img src="../images/'.$row['photos'].'" width="25" height="25" />&nbsp;&nbsp;<a href="post_list.php?del_img='.$row['p_id'].'" style="padding: 0px 0px 0px 0px; font-size: 12px;"  class="btn btn-danger btn-sm">Delete</a></td>
                                          <td>'.html_entity_decode(substr($row['contents'],0,30)).' ......</td>
										  <td><a class="btn btn-secondary btn-sm"><strong>'.$row['status'].'</strong></a></td>
										  <td>'.($row['status'] == 'draft' ? '<a href="post_list.php?new_status=publish&p_id='.$row['p_id'].'" class="btn btn-primary btn-sm">Publish</a>': '<a href="post_list.php?new_status=draft&p_id='.$row['p_id'].'" class="btn btn-primary btn-sm">Draft</a>').'</td>
										  <td><a href="edit_post.php?edit_id='.$row['p_id'].'" class="btn btn-warning btn-sm">Edit</a></td>
										  <td><a href="../index.php#'.pslugs($row['ptitle']).'" class="btn btn-info btn-sm" target="_blank">View</a></td>
										  <td><a href="post_list.php?del_id='.$row['p_id'].'" class="btn btn-danger btn-sm">Delete</a></td>
                                          </tr>';
                                          $number++;
                                          }
                                          ?>
                                        </tbody>
                                    </table>
                                  </div> <!-- /card block -->
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
