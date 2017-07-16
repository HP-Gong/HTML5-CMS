<!-- Header -->
<header id="header">
<?php 
global $conn;
$sql = "SELECT * FROM content";
$results = $conn->query($sql);
$row = $results->fetch(PDO::FETCH_ASSOC);
echo '<div class="logo">
<span class="'.$row['logo_icons'].'"></span>
</div>
<div class="content">
<div class="inner">
<h1>'.$row['ctitle'].'</h1>
<p>'.html_entity_decode($row['info']).'</p>
</div>
</div>'
?>
<nav>
<ul>
<?php 
global $conn;
$sql = "SELECT * FROM posts WHERE status = 'publish' ORDER BY p_id"; 
$result = $conn->query($sql);
while($row = $result->fetch(PDO::FETCH_ASSOC)){
echo '<li><a href="index.php#'.pslugs($row['ptitle']).'">'.$row['ptitle'].'</a></li>';
}
?>
<li><a href="#contact">Contact</a></li>
</ul>
</nav>
</header>			