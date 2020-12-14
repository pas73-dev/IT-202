<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
//we use this to safely get the email to display
$email = "";
if (isset($_SESSION["user"]) && isset($_SESSION["user"]["email"])) {
    $email = $_SESSION["user"]["email"];
}
?>
    <p>Welcome, <?php echo $email; ?></p>
<?php
//this gets Weekly score from the database from all users with a score
$Wresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, Scores.score as  score FROM Users JOIN Scores on Users.id = Scores.user_id where YEARWEEK(Scores.created) = (YEARWEEK(NOW()) -1) order by Scores.score desc, Scores.created asc LIMIT 10");
    $stmt->execute([]);
    $Wresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="Wresults">
    <div>
	 <li><a href="pong.php">Go to Game</a></li>
         <div>Last Week Top 10 Score</div>
	 <div>Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Score &nbsp&nbsp Date</div>
    </div>
    <?php if (count($Wresults) > 0): ?>
        <div class="list-group">
            <?php foreach ($Wresults as $w): ?>
                <div class="list-group-item">
                    <div>
			<div> <a href="profile.php?id=<?php echo $w["user_id"];?>"><?php safer_echo($w["name"]); ?> </a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <?php safer_echo($w["score"]);?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <?php safer_echo($w["date"]); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
     <?php else: ?>
        <p>No results</p>
    <?php endif; ?>
</div>
<?php

//this gets monthly score
$Mresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, Scores.score as score FROM Users JOIN Scores on Users.id = Scores.user_id where DATE_FORMAT(Scores.created, '%Y%m') = (DATE_FORMAT(NOW(), '%Y%m') - 1) order by Scores.score desc, Scores.created asc LIMIT 10");
    $stmt->execute([]);
    $Mresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="Mresults">
    <div>
        <p></p> <div>Last Month Top 10 Score</div>
	<div>Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Score &nbsp&nbsp Date</div>
    </div>
    <?php if (count($Mresults) > 0): ?>
        <div class="list-group">
            <?php foreach ($Mresults as $m): ?>
                <div class="list-group-item">
                    <div>
			<div> <a href="profile.php?id=<?php echo $m["id"];?>"><?php safer_echo($m["name"]); ?> </a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <?php safer_echo($m["score"]);?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <?php safer_echo($m["date"]); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
     <?php else: ?>
        <div>No results</div>
    <?php endif; ?>
</div>
<?php

//this gets lifetime score
$Lresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, Scores.score as score FROM Users JOIN Scores on Users.id = Scores.user_id order by Scores.score desc, Scores.created asc LIMIT 10");
    $stmt->execute([]);
    $Lresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="Lresults">
    <div>
        <p></p> <div>Top 10 Lifetime Score</div>
	<div>Name &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Score &nbsp&nbsp Date</div>
    </div>
    <?php if (count($Lresults) > 0): ?>
        <div class="list-group">
            <?php foreach ($Lresults as $l): ?>
                <div class="list-group-item">
                    <div>
			<div><a href="profile.php?id="><?php safer_echo($l["name"]); ?></a> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <?php safer_echo($l["score"]);?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp; <?php safer_echo($l["date"]); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
     <?php else: ?>
        <div>No results</div>
    <?php endif; ?>
</div>
<?php require(__DIR__ . "/partials/flash.php");
