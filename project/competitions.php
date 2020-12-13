<?php require_once(__DIR__ . "/partials/nav.php"); ?>
<?php
//this is were the user can join any active competition
if (!is_logged_in()) {
    //this will redirect to login and kill the rest of this script (prevent it from executing)
    flash("You don't have permission to access this page");
    die(header("Location: login.php"));
}
?>
<?php
$db = getDB();
if (isset($_POST["join"])) {
    $balance = getBalance();
    //prevent user from joining expired or paid out comps
    $stmt = $db->prepare("select fee from Competitions where id = :id && expires > current_timestamp && paid_out = 0");
    $r = $stmt->execute([":id" => $_POST["cid"]]);
    if ($r) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $fee = (int)$result["fee"];
            if ($balance >= $fee) {
                $stmt = $db->prepare("INSERT INTO Association (user_id, comp_id) VALUES(:uid, :cid)");
                $r = $stmt->execute([":cid" => $_POST["cid"], ":uid" => get_user_id()]);
                if ($r) {
                    flash("Successfully join competition", "success");
                    die(header("Location: #"));
                }
                else {
                    flash("There was a problem joining the competition: " . var_export($stmt->errorInfo(), true), "danger");
                }
            }
            else {
                flash("You can't afford to join this competition, try again later", "warning");
            }
        }
        else {
            flash("Competition is unavailable", "warning");
        }
    }
    else {
        flash("Competition is unavailable", "warning");
    }
}
$stmt = $db->prepare("UPDATE Competitions set participants = (select count(id) from Association where Association.user_id = :id) where user_id = :id");
$q = $stmt->execute([":id" => get_user_id(),]);
//https://www.digitalocean.com/community/tutorials/how-to-implement-pagination-in-mysql-with-php-on-ubuntu-18-04
$page = 1;
$per_page = 10;
if(isset($_GET["page"])){
    try {
        $page = (int)$_GET["page"];
    }
    catch(Exception $e){

    }
}
$results = [];
$result = [];
$db = getDB();
$stmt = $db->prepare("SELECT count(*) as total from Scores e LEFT JOIN Users i on e.id = i.user_id where e.user_id = :id");
$stmt->execute([":id"=>get_user_id()]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$total = 0;
if($result){
    $total = (int)$result["total"];
}
$total_pages = ceil($total / $per_page);
$offset = ($page-1) * $per_page;
$stmt = $db->prepare("SELECT c.*, UC.user_id as reg FROM Competitions c LEFT JOIN (SELECT * FROM Association where user_id = :id) as UC on c.id = UC.comp_id WHERE c.expires > current_timestamp AND paid_out = 0 ORDER BY expires ASC LIMIT :offset, :count");
$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
$stmt->bindValue(":count", $per_page, PDO::PARAM_INT);
$stmt->bindValue(":id", get_user_id());
$e = $stmt->execute();
if ($e) {
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
else {
    flash("There was a problem looking up competitions: " . var_export($stmt->errorInfo(), true), "danger");
}
?>
    <div class="container-fluid">
        <h3>Competitions</h3>
        <div class="list-group">
            <?php if (isset($results) && count($results)): ?>
                <div class="list-group-item font-weight-bold">
                        <div>
				<div><?php safer_echo("Name"); ?> &nbsp&nbsp; <?php safer_echo("Participants");?> &nbsp&nbsp; <?php safer_echo("Required Score");?> &nbsp&nbsp; <?php safer_echo("Reward");?> &nbsp&nbsp; <?php safer_echo("Expires");?> &nbsp&nbsp; <?php safer_echo("Action");?> </div>
                        </div>
                </div>
                <?php foreach ($results as $r): ?>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col">
                                <?php safer_echo($r["name"]); ?>
                            </div>
                            <div class="col">
                                <?php safer_echo($r["participants"]); ?>
                            </div>
                            <div class="col">
                                <?php safer_echo($r["min_score"]); ?>
                            </div>
                            <div class="col">
                                <?php safer_echo($r["reward"]); ?>
                                <!--TODO show payout-->
                            </div>
                            <div class="col">
                                <?php safer_echo($r["expires"]); ?>
                            </div>
                            <div class="col">
                                <?php if ($r["reg"] != get_user_id()): ?>
                                    <form method="POST">
                                        <input type="hidden" name="cid" value="<?php safer_echo($r["id"]); ?>"/>
                                        <input type="submit" name="join" class="btn btn-primary"
                                               value="Join (Cost: <?php safer_echo($r["fee"]); ?>)"/>
                                    </form>
                                <?php else: ?>
                                    Already Registered
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="list-group-item">
                    No competitions available right now
                </div>
            <?php endif; ?>
        </div>
    </div>
<nav aria-label="My competition List">
            <ul class="pagination justify-content-center">
                <li class="page-item <?php echo ($page-1) < 1?"disabled":"";?>">
                    <a class="page-link" href="?page=<?php echo $page-1;?>" tabindex="-1">Previous</a>
                </li>
                <?php for($i = 0; $i < $total_pages; $i++):?>
                <li class="page-item <?php echo ($page-1) == $i?"active":"";?>"><a class="page-link" href="?page=<?php echo ($i+1);?>"><?php echo ($i+1);?></a></li>
                <?php endfor; ?>
                <li class="page-item <?php echo ($page) >= $total_pages?"disabled":"";?>">
                    <a class="page-link" href="?page=<?php echo $page+1;?>">Next</a>
                </li>
            </ul>
        </nav>
<?php require(__DIR__ . "/partials/flash.php");
