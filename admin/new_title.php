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

$result = "";
	
if(isset($_POST['submit_main'])){

$mtitle = filter_input(INPUT_POST, 'mtitle', FILTER_SANITIZE_STRING);
$mtitle = strip_tags(trim($_POST['mtitle']));
$logo_icons = filter_input(INPUT_POST, 'logo_icons', FILTER_SANITIZE_STRING);
$logo_icons = strip_tags(trim($_POST['logo_icons']));
$ctitle = filter_input(INPUT_POST, 'ctitle', FILTER_SANITIZE_STRING);
$ctitle = strip_tags(trim($_POST['ctitle']));
$info = filter_input(INPUT_POST, 'info', FILTER_SANITIZE_STRING);
$info = htmlentities(strip_tags($_POST['info'], '<a>|<br>'));
$footer = filter_input(INPUT_POST, 'footer', FILTER_SANITIZE_STRING);
$footer = htmlentities(strip_tags($_POST['footer'], '<a>|<br>'));

global $conn;
$sql1 = "UPDATE content SET mtitle='$mtitle', logo_icons='$logo_icons', ctitle='$ctitle', info='$info', footer='$footer'";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindValue(':mtitle', $mtitle, PDO::PARAM_STR);
$stmt1->bindValue(':logo_icons', $logo_icons, PDO::PARAM_STR);
$stmt1->bindValue(':ctitle', $ctitle, PDO::PARAM_STR);
$stmt1->bindValue(':info', $info, PDO::PARAM_STR);
$stmt1->bindValue(':footer', $footer, PDO::PARAM_STR);
$date = date('Y-m-d h:i:s');
$stmt1->execute(array(":mtitle" => $mtitle, ":logo_icons" => $logo_icons, ":ctitle" => $ctitle, ":info" => $info, ":footer" => $footer));

$result = '<div class="alert alert-success">Title & Info is Updated!</div>';
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
                                    <i class="fa fa-file-o"></i> Title & Info
                                </div>
                               <!-- /card-header -->
                               <!-- card-block -->
                               <div class="card-block">
							  <?php 
                              global $conn;
                              if(isset($_GET['edit_id'])){
                              $edit_id = $_GET['edit_id'];
                              $stmt2 = $conn->query("SELECT * FROM content WHERE c_id='".$edit_id."'");
                              while($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {?>
                                    <form action="new_title.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="mtitle">Top Title</label>
                                            <div class="col-md-9">
                                                <input type="text" id="mtitle" name="mtitle" class="form-control" value="<?php echo $row['mtitle']; ?>" required> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="logo_icons">Logo Icon</label>
                                            <div class="col-md-9">
                                                <input type="text" id="logo_icons" name="logo_icons" class="form-control" value="<?php echo $row['logo_icons']; ?>" required> 
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="ctitle">Main Title</label>
                                            <div class="col-md-9">
                                                <input type="text" id="ctitle" name="ctitle" class="form-control" value="<?php echo $row['ctitle']; ?>" required> 
                                            </div>
                                        </div>
                                         <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="info">Description</label>
                                            <div class="col-md-9">
                                                <textarea id="info" name="info" rows="9" class="form-control"><?php echo html_entity_decode($row['info']); ?></textarea>
                                            </div>
                                        </div>   
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="footer">Footer</label>
                                            <div class="col-md-9">
                                                <textarea id="footer" name="footer" rows="9" class="form-control"><?php echo html_entity_decode($row['footer']); ?></textarea>
                                            </div>
                                        </div>  
                                      <div class="form-group row">
                                      <div class="col-md-9">
                                    <button type="submit" id="submit_main" name="submit_main" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                                    </div> 
                                    </div> 
                                    </form>
                                 </div> <!-- /card block -->
                                <?php } }?>
                                  <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Top Title</th>
                                                <th>Logo Icon</th>
                                                <th>Main Title</th>
                                                <th>Description</th>
                                                <th>Footer</th>
                                                <th>Edit Title & Info</th>
                                                <th>View Title & Info</th>
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
                                              <td>'.substr($row['info'],0,50).' ......</td>
                                              <td>'.$row['footer'].'</td>
                                              <td><a href="new_title.php?edit_id='.$row['c_id'].'" class="btn btn-warning btn-sm">Edit</a></td>
                                              <td><a href="../index.php#'.pslugs($row['ctitle']).'" class="btn btn-info btn-sm" target="_blank">View</a></td>
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
        <script type="text/javascript" src="tinymce/tinymce.min.js"></script>
		<script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            theme: "modern",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true,
			relative_urls: false,
            templates: [
                {title: 'Test template 1', content: 'Test 1'},
                {title: 'Test template 2', content: 'Test 2'}
            ],
        });
        </script>

    </body>
</html>
