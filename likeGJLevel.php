<?php
require "incl/connection.php";
require "incl/config.php";
// secret check
if (!isset($_POST["secret"]) || $_POST["secret"] !== "Wmfd2893gb7") {
    exit("-1, not the secret");
}
// get level id
$levelID = intval($_POST["levelID"]);
// update db
$query = $conn->prepare("UPDATE levels SET likes = likes + 1 WHERE levelID = :levelID");
$query->execute([":levelID" => $levelID]);
echo "1";
?>
