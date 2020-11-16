<link rel="stylesheet" href="static/css/styles.css">
<?php
//we'll be including this on most/all pages so it's a good place to include anything else we want on those pages
require_once(__DIR__ . "/../lib/helpers.php");
?>
<nav>
<ul class="nav">
    <li><a href="home.php">Home</a></li>
    <?php if (!is_logged_in()): ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
    <?php endif; ?>
   /* <?php if (has_role("Admin")): ?>
            <li><a href="test_create_pointhistory.php">Create Point History</a></li>
	    <li><a href="test_edit_pointhistory.php">Edit Points</a></li>
            <li><a href="test_list_pointhistroy.php">List Point History</a></li>
	    <li><a href="test_view_pointhistory.php">View Point History</a></li>
        <?php endif; ?>*/
    <?php if (is_logged_in()): ?>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
	<li><a href="pong.html">Game</a></li>
    <?php endif; ?>
</ul>
</nav>
