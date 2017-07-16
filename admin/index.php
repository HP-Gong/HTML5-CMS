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
                                 <div class="card-header"><i class="fa fa-user"></i> Admin Section</div>
                               <!-- /card-header -->
                               <!-- card-block -->
                                <div class="card-block">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Top Title</th>
                                                <th>Logo Icon</th>
                                                <th>Main Title</th>
                                                <th>Description</th>
                                                <th>Footer</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
											global $conn;
											$sql = "SELECT * FROM content";
											$result = $conn->query($sql);
											while($row = $result->fetch(PDO::FETCH_ASSOC)){
											echo '
											<tr>
											<td>'.$row['mtitle'].'</td>
											<td>'.$row['logo_icons'].'</td>
											<td>'.$row['ctitle'].'</td>
											<td>'.html_entity_decode(substr($row['info'],0,50)).' ......</td>
											<td>'.html_entity_decode($row['footer']).'</td>
											</tr>';
											}
											?>
                                        </tbody>
                                    </table>
                                  </div> <!-- /card block -->
                                </div> <!-- /card -->
                            </div><!-- /col-lg-12 -->
                          </div>
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
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Title</th>
                                                <th>Images</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  <?php 
                                              global $conn;
                                              $sql = "SELECT * FROM posts";
                                              $result = $conn->query($sql);
                                              $number = 1;
                                              while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                              echo '
                                              <tr>
                                              <td>'.$number.'</td>
                                              <td>'.$row['ptitle'].'</td>
					                          <td><img src="../images/'.$row['photos'].'" width="35" height="35" /></td>
                                              <td>'.html_entity_decode(substr($row['contents'],0,50)).' ......</td>
                                              <td>'.$row['date'].'</td>
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
                       <div id="ui-view">
                         <div class="col-lg-12"> <!-- col-lg-12 -->
                            <div class="card"> <!-- card -->
                                 <!-- card-header -->
                                 <div class="card-header">
                                    <i class="fa fa-list"></i>Social Lists
                                </div>
                               <!-- /card-header -->
                               <!-- card-block -->
                                <div class="card-block">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Title</th>
                                                <th>Icons</th>
                                                <th>Links</th>
                                            </tr>
                                        </thead>
                                        <tbody>
											<?php 
                                                global $conn;
                                                $sql = "SELECT * FROM social";
                                                $result = $conn->query($sql);
                                                $number = 1;
                                                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                                                echo '
                                                <tr>
                                                <td>'.$number.'</td>
                                                <td>'.$row['stitle'].'</td>
                                                <td>'.$row['icons'].'</td>
                                                <td>'.$row['links'].'</td>
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
                 </div><!-- /.conainer-fluid -->
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
