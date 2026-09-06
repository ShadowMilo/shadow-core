<?php
include "incl/connection.php";
include "incl/gdpsLib.php";
require "incl/ExploitPatch.php";

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

$gameVersion = EXPLOIT::charclean($_POST["gameVersion"]);
$udid = EXPLOIT::clean($_POST["udid"]);
$userName = EXPLOIT::clean($_POST["userName"]);
$userID = GDPS::getUserID($udid, $userName);

$levelID = EXPLOIT::number($_POST["levelID"]);
$levelName = EXPLOIT::clean($_POST["levelName"]);
$levelDesc = GDPS::base64url_encode($_POST["levelDesc"]);
$levelString = $_POST["levelString"];
$levelVersion = EXPLOIT::number($_POST["levelVersion"]);
$levelLength = EXPLOIT::number($_POST["levelLength"]);
$audioTrack = EXPLOIT::number($_POST["audioTrack"]);

if ($levelID == 0) {
    $updateTrending = $conn->prepare("UPDATE levels SET trendingScore = trendingScore - 10 WHERE trendingScore > -10");
    $updateTrending->execute();
    
    $query = $conn->prepare("INSERT INTO levels (name, udid, song, gameVersion, version, description, userID, username, length) VALUES (:name, :udid, :song, :gameVersion, :version, :description, :userID, :username, :length)");
    $query->execute([
        ":name" => $levelName,
        ":udid" => $udid,
        ":song" => $audioTrack,
        ":gameVersion" => $gameVersion,
        ":version" => $levelVersion,
        ":description" => $levelDesc,
        ":userID" => $userID,
        ":username" => $userName,
        ":length" => $levelLength
    ]);

    $query = $conn->prepare("SELECT * FROM levels ORDER BY levelID DESC LIMIT 1");
    $query->execute();
    $newLevelID = $query->fetchAll();
    $newLevelID = $newLevelID[0]["levelID"];

    file_put_contents("levels/$newLevelID", $levelString);
    echo $newLevelID;
} else {
    // Update the level
    $query = $conn->prepare("UPDATE levels SET version = :version, length = :length WHERE levelID = :levelID");
    $query->execute([
        ":version" => $levelVersion,
        ":length" => $levelLength,
        ":levelID" => $levelID
    ]);

    file_put_contents("levels/$levelID", $levelString);
    echo $levelID;
}

?>
