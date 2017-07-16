<article id="contact">
<h2 class="major">Contact</h2>
<form method="POST" action="contact/c_process.php">
<div class="field half first">
<label for="name">Name</label>
<input type="text" name="name" id="name" placeholder="Name" required>
</div>
<div class="field half">
<label for="email">Email</label>
<input type="email" name="email" id="email" placeholder="E-mail" required>
</div>
<div class="field">
<label for="message">Message</label>
<textarea name="message" id="message" placeholder="Message" rows="4"></textarea>
</div>
<ul class="actions">
<li><input type="submit" id="btn" class="btn" value="SUBMIT"></li>
<li><input type="reset" value="Reset" /></li>
</ul>
</form>
<ul class="icons">
<?php 
global $conn;
$sql = "SELECT * FROM social WHERE status = 'publish' ORDER BY s_id"; 
$result = $conn->query($sql);
while($row = $result->fetch(PDO::FETCH_ASSOC)){
echo '<li><a href="'.$row['links'].'" class="'.$row['icons'].'" target="_blank"></a></li>';
}
?>
</ul>
</article>

