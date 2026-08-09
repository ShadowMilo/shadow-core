<?php
include "incl/connection.php";
include "incl/gdpsLib.php";

// Secret
if (!isset($_POST["secret"]) || $_POST["secret"] != "Wmfd2893gb7") {
    exit("-1, not the secret");
}

// Level ID
if (!isset($_POST["levelID"])) {
    exit("-1, give level id");
}

// UDID
if (!isset($_POST["udid"])) {
    exit("-1, give udid");
}

$gameVersion = $_POST["gameVersion"];
$udid = $_POST["udid"];
$userName = $_POST["userName"];
$userID = GDPS::getUserID($udid, $userName);

$levelID = $_POST["levelID"];
$levelName = $_POST["levelName"];
$levelDesc = GDPS::base64url_encode($_POST["levelDesc"]);
$levelString = $_POST["levelString"];
$levelVersion = $_POST["levelVersion"];
$levelLength = $_POST["levelLength"];
$audioTrack = $_POST["audioTrack"];

if ($levelID == 0) {
    $updateTrending = $conn->prepare("UPDATE levels SET trendingScore = :trendingScore - 10 WHERE trendingScore > -10");
    $updateTrending->execute();
    $query = $conn->prepare("INSERT INTO levels (name, diff, song, gameVersion, version, downloads, likes, description, userID, username, length) VALUES ('$levelName', '0', '$audioTrack', '$gameVersion', '$levelVersion', '0', '0', '$levelDesc', '$userID', '$userName', '$levelLength')");
    $query->execute();

    $query = $conn->prepare("SELECT * FROM levels ORDER BY levelID DESC LIMIT 1");
    $query->execute();
    $newLevelID = $query->fetchAll();
    $newLevelID = $newLevelID[0]["levelID"];

    file_put_contents("levels/$newLevelID", $levelString);
    echo $newLevelID;
} else {
    // Update the level
    $query = $conn->prepare("UPDATE levels SET version = :levelVersion, length = :length WHERE levelID = :levelID");
    $query->execute(["version" => $levelVersion, "length" => $levelLength, "levelID" => $levelID]);

    file_put_contents("levels/$levelID", $levelString);
    echo $levelID;
}

?>
