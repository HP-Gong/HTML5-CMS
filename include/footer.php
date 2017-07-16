<!-- Footer -->
<?php 
global $conn;
$sql = "SELECT * FROM content";
$results = $conn->query($sql);
$row = $results->fetch(PDO::FETCH_ASSOC);
echo '<footer id="footer"><p class="copyright">'.html_entity_decode($row['footer']).'</p></footer>';
?>
