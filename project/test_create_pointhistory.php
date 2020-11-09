<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
if (!has_role("Admin")) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>

<form method="POST">
	<label>Points History</label>
	<input type="number" min="1" name="points_change"/>
	<input type="submit" name="save" value="Create"/>
</form>

<?php
if(isset($_POST["save"])){
	//TODO add proper validation/checks
	$score = $_POST["points_change"];
	$user = get_user_id();
	$db = getDB();
	$stmt = $db->prepare("INSERT INTO PointsHistory (points_change, user_id) VALUES(:points_change, :user)");
	$r = $stmt->execute([
		":points_change"=>$points_change,
		":user"=>$user
	]);
	if($r){
		flash("Created successfully with id: " . $db->lastInsertId());
	}
	else{
		$e = $stmt->errorInfo();
		flash("Error creating: " . var_export($e, true));
	}
}
?>
<?php require(__DIR__ . "/partials/flash.php");

