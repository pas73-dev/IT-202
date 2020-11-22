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
//this gets weekly score
$score = [];
$results = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT score FROM Users JOIN Scores on Users.id = Scores.user_id where Users.id = :sid order by Scores.created desc LIMIT 10");
    $stmt->execute([":sid" => get_user_id()]);
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["score"] = $score;
?>
<?php
//this gets Monthly score
$score = [];
$results = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT score FROM Users JOIN Scores on Users.id = Scores.user_id where Users.id = :sid order by Scores.created desc LIMIT 10");
    $stmt->execute([":sid" => get_user_id()]);
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["score"] = $score;
?>
<?php
//this gets Lifetime score
$score = [];
$results = [];
    $db = getDB();
    $stmt = $db->prepare("SELECT score FROM Users JOIN Scores on Users.id = Scores.user_id where Users.id = :sid order by Scores.created desc LIMIT 10");
    $stmt->execute([":sid" => get_user_id()]);
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $_SESSION["score"] = $score;
?>
<?php require(__DIR__ . "/partials/flash.php");
