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
$results = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, score FROM Users JOIN Scores on Users.id = Scores.user_id where  order by Scores.created desc LIMIT 10");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//this gets monthly score
$score = [];
$results = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, score FROM Users JOIN Scores on Users.id = Scores.user_id where convert(varchar(6), Scores.created, 112) = CONVERT (varchar(6), DATEADD(Month, -1, GETDATE()), 112) order by Scores.score, Scores.created desc LIMIT 10");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
//this gets lifetime score
$score = [];
$results = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT Users.username as name, Scores.created as date, score FROM Users JOIN Scores on Users.id = Scores.user_id order by Scores.score, Scores.created desc LIMIT 10");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php require(__DIR__ . "/partials/flash.php");
