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
$score = [];
$Wresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, score FROM Users JOIN Scores on Users.id = Scores.user_id where RIGHT(YEARWEEK(Scores.created), 2) = (RIGHT(YEARWEEK(NOW()), 2) -1) order by Scores.score, Scores.created desc LIMIT 10");
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
                        <div><?php safer_echo($w["score"]); ?></div>
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
$score = [];
$Mresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, score FROM Users JOIN Scores on Users.id = Scores.user_id where convert(varchar(6), Scores.created, 112) = CONVERT (varchar(6), DATEADD(Month, - 1, NOW()), 112) order by Scores.score, Scores.created desc LIMIT 10");
    $Mresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//this gets lifetime score
$score = [];
$Lresults = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, score FROM Users JOIN Scores on Users.id = Scores.user_id order by Scores.score, Scores.created desc LIMIT 10");
    $Lresults = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require(__DIR__ . "/partials/flash.php");
