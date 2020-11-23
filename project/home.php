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
//this gets Weekly score
$Wresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, Scores.score as  score FROM Users JOIN Scores on Users.id = Scores.user_id where YEARWEEK(Scores.created) = (YEARWEEK(NOW()) -1) order by Scores.score desc, Scores.created asc LIMIT 10");
    $stmt->execute([]);
    $Wresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="Wresults">
    <div>
         <div>Last Week Top 10 Score</div>
    </div>
    <?php if (count($Wresults) > 0): ?>
        <div class="list-group">
            <?php foreach ($Wresults as $w): ?>
                <div class="list-group-item">
                    <div>
			<div><?php safer_echo($w["name"]); ?> &nbsp&nbsp&nbsp; <?php safer_echo($w["score"]);?> &nbsp&nbsp&nbsp <?php safer_echo($w["date"]); ?></div>
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
    $stmt = $db->prepare("SELECT Users.username as Mname, Scores.created as Mdate, Scores.score as Mscore FROM Users JOIN Scores on Users.id = Scores.user_id where DATE_FORMAT(Scores.created, '%Y%m') = DATE_FORMAT(NOW(), '%Y%m') order by Scores.score desc, Scores.created asc LIMIT 10");
    $Mresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="Mresults">
    <div>
        <p></p> <div>Last Month Top 10 Score</div>
    </div>
    <?php if (count($Mresults) > 0): ?>
        <div class="list-group">
            <?php foreach ($Mresults as $m): ?>
                <div class="list-group-item">
                    <div>
			<div><?php safer_echo($m["Mname"]); ?> &nbsp&nbsp&nbsp <?php safer_echo($m["Mscore"]); ?> &nbsp&nbsp&nbsp <?php safer_echo($m["Mdate"]); ?></div>
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
    $stmt = $db->prepare("SELECT Users.username as Lname, Scores.created as Ldate, Scores.score as Lscore FROM Users JOIN Scores on Users.id = Scores.user_id order by Scores.score desc, Scores.created asc LIMIT 10");
    $Lresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="Lresults">
    <div>
        <p></p> <div>Top 10 Lifetime Score</div>
    </div>
    <?php if (count($Lresults) > 0): ?>
        <div class="list-group">
            <?php foreach ($Lresults as $l): ?>
                <div class="list-group-item">
                    <div>
			<div><?php safer_echo($l["Lname"]); ?> &nbsp&nbsp&nbsp <?php safer_echo($l["Lscore"]); ?> &nbsp&nbsp&nbsp <?php safer_echo($l["Ldate"]); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
     <?php else: ?>
        <div>No results</div>
    <?php endif; ?>
</div>
<?php require(__DIR__ . "/partials/flash.php");
