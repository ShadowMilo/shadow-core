<?php
include "incl/connection.php";
include "incl/gdpsLib.php";

// Secret
if (!isset($_POST["secret"]) || $_POST["secret"] != "Wmfd2893gb7") {
    exit("-1, not the secret");
}

// Level ID
if (!isset($_POST["levelID"])) {
    exit("-1, give level id pls");
}

$levelID = $_POST["levelID"];

// Xan was here.
$query = $conn->prepare("SELECT * FROM levels WHERE levelID = :levelID");
$query->execute([":levelID" => $levelID]);
$level = $query->fetch(PDO::FETCH_ASSOC);

// Getting the levelString
$path = "levels/$levelID";
if (file_exists($path)) {
    $levelstring = file_get_contents($path);
} else {
    exit("-1, not a level");
}

// Level Object
$response = "1:{$level["levelID"]}:2:{$level["name"]}:3:".GDPS::base64url_decode($level["description"]).":4:$levelstring:5:{$level["version"]}:6:{$level["userID"]}:10:{$level["downloads"]}:14:{$level["likes"]}:15:{$level["length"]}";

echo $response;
?>
