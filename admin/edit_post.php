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
	
if(isset($_POST['submit_epost'])){

$ptitle = filter_input(INPUT_POST, 'ptitle', FILTER_SANITIZE_STRING);
$ptitle = strip_tags(trim($_POST['ptitle']));
$contents = filter_input(INPUT_POST, 'contents', FILTER_SANITIZE_STRING);
$contents = htmlentities(strip_tags($_POST['contents'], '<i>|<p>|<a>|<br>|<img>'));
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
$status = strip_tags(trim($_POST['status']));

	global $conn;
    $photos = $_FILES['photos']['name'];
    $photo_loc = $_FILES['photos']['tmp_name'];
	$folder="../images/";
	
if(isset($photos)){
    if(!empty($photos)){
	if(move_uploaded_file($photo_loc,$folder.$photos)){
		$sql1 = "UPDATE posts SET ptitle='$ptitle', photos='$photos', contents='$contents', status='$status' WHERE p_id = '".$_POST['edit_id']."'";
		$stmt1 = $conn->prepare($sql1);
		$stmt1->bindValue(':ptitle', $ptitle, PDO::PARAM_STR);
		$stmt1->bindValue(':contents', $contents, PDO::PARAM_STR);
		$stmt1->bindValue(':status', $status, PDO::PARAM_STR);
		$stmt1->execute(array(":ptitle" => $ptitle, ":photos" => $photos, ":contents" => $contents, ":status" => $status));
		header("Location: post_list.php");
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
                        <div class="col-lg-8"> <!-- col-lg-8 -->
                            <div class="card"> <!-- card -->
                                 <!-- card-header -->
                                 <div class="card-header">
                                    <i class="fa fa-edit"></i> Edit Posts
                                </div>
                               <!-- /card-header -->
								<?php
                                global $conn;
                                if(isset($_GET['edit_id'])){
                                $edit_id = $_GET['edit_id'];
                                $stmt = $conn->query("SELECT * FROM posts WHERE p_id='".$edit_id."'");
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {?>
                                <div class="card-block">
                                   <form action="edit_post.php" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="ptitle">Title</label>
                                            <div class="col-md-10">
                                                <input type="text" id="ptitle" name="ptitle" class="form-control" value="<?php echo $row['ptitle']; ?>" required> 
                                            </div>
                                        </div>
                                      <div class="form-group row">
                                      <label class="col-md-1 form-control-label" for="photos">Image:</label>
                                      <div class="col-md-10">
                                      <input type="file" name="photos" required> 
                                      <img src="../images/<?php echo $row['photos']; ?>" width="30" height="30" />
                                      </div>
                                      </div>
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="contents">Description</label>
                                            <div class="col-md-10">
                                                <textarea id="contents" name="contents" rows="9" class="form-control"><?php echo html_entity_decode($row['contents']); ?></textarea>
                                            </div>
                                        </div>    
                                        <div class="form-group row">
                                            <label class="col-md-1 form-control-label" for="select">Status:</label>
                                            <div class="col-md-9">
                                                <div class="draft">
                                                    <label for="draft">
                                                        <input type="radio" id="status" name="status" value="draft">Draft
                                                    </label>
                                                </div>
                                                <div class="publish">
                                                    <label for="publish">
                                                        <input type="radio" id="status" name="status" value="publish">Publish
                                                    </label>
                                                </div>
                                            </div>
                                         </div>
                                    <div class="form-group row">
                                    <div class="col-md-9">
                                    <input type="hidden" name="edit_id" value="<?php echo $_GET['edit_id']; ?>" />          
                                    <button type="submit" id="submit_epost" name="submit_epost" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                                    <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                                    </div>
                                     </div>
                                    </form>
                                    </div> <!-- /card block -->
                                  <?php }} ?>
                                </div> <!-- /card -->
                            </div><!-- /col-lg-8 -->
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
