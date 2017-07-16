<?php
session_start();
session_unset();
session_destroy();
session_set_cookie_params(0);
header("location: index.php");
exit();
?>
