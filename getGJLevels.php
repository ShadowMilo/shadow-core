<?php
include "incl/connection.php";
include "incl/config.php";

// check secret
if (!isset($_POST["secret"]) || $_POST["secret"] !== "Wmfd2893gb7") {
    exit("-1, thats not the secret silly");    
}
if (!isset($_POST["type"])) {
    exit("-1, please supply a search type sir");
}

// params from client
$page = isset($_POST["page"]) ? $_POST["page"] : 0;
$type = $_POST["type"];
$str = isset($_POST["str"]) ? $_POST["str"] : "";
$diff = isset($_POST["diff"]) ? $_POST["diff"] : "";

// what do these even do?
$where = null;
$order = null;

// types of searching oh joy
switch ($type) {
    case 0:
        // they searching a name
        if (is_numeric($str)) {
            // oh wait its an id, so we search by id instead
            $where = "WHERE levelID = '{$str}%'";
        } else {
            $where = "WHERE name LIKE '%{$str}%'";
        }
        break;
    case 1:
        // search by downloads
        $order = "ORDER BY downloads DESC";
        break;
    case 2:
        // search by likes
        $order = "ORDER BY likes DESC";
        break;
    case 4:
        // TO THE RECENT TAAAAAAAAAAAAAB
        $order = "ORDER BY levelID DESC";
        break;
    case 5:
        // user's levels (not gonna work yet)
        if (is_numeric($str)) {
            $where = "WHERE userID = '{$str}'";
            $order = "ORDER BY levelID DESC";
        } else {
            exit("-1, user ids are numeric dumdum");
        }
        break;
    default:
        exit("-1, thats not a search type silly");
        
}

// difficulty filters
$diffSql = null;
if ($diff != "-") {
    $diffs = explode(",", $diff);

    if (isset($where)) {
        $diffSql = " AND (";
    } else {
        $diffSql = " WHERE (";
    }

    $diffSql .= "(";
    foreach ($diffs as $difficulty) {
        if ($difficulty != -1) {
            $diffnum = "{$difficulty}0";
        } else {
            $diffnum = 0;
        }
        if ($difficulty == $diffs[array_key_last($diffs)]) {
            $diffSql .= "diff = {$diffnum}";
        } else {
            $diffSql .= "diff = {$diffnum} OR ";
        }
    }
    $diffSql .= ")";
}
//that stuff was taken from MirrorCore, got zero clue how that works.


//this probably fetches the levels
$query = $conn->prepare("SELECT * FROM levels $where $diffSql $order LIMIT 10 OFFSET {$page}0");
$query->execute();
$levelResult = $query->fetchAll();

//are there even levels?
if (empty($levelResult)) {
    exit("-1, theres no levels here");
}

//how many levels?
if ($realLevelCount) {
    $query = $conn->prepare("SELECT COUNT(*) FROM levels $where $diffSql");
    $query->execute();
    $amountOfLevels = $query->fetchColumn();
}

//create the response
//gd is stupid so this is weird
$response = "";

//level object
//why is this in the php and not in the client
$levelObject = null;
$creatorObject = null;
foreach ($levelResult as $row) {
    // i guess we're doing fractions or something????
    if ($row["diff"] == 0) {
        $difficultyDenominator = 0;
    } else {
        $difficultyDenominator = 10;
    }

    //parameter time :)
    $levelObject .= "1:{$row['levelID']}:2:{$row['name']}:3:{$row['description']}:5:{$row['version']}:6:{$row['userID']}:8:{$difficultyDenominator}:9:{$row['diff']}:10:{$row['downloads']}:11:0:12:{$row['song']}:13:{$row['gameVersion']}:14:{$row['likes']}:15:{$row['length']}|";
    $creatorObject .= "{$row['userID']}:{$row['username']}|";
}
$levelObject = substr($levelObject, 0, -1);
$creatorObject = substr($creatorObject, 0, -1);
$response .= "{$levelObject}#{$creatorObject}";
// allat for *one level*
// i hate gd sometimes

//Page Object
//whyyyyyyyy
if ($realLevelCount) {
    $response .= "{$amountOfLevels}";
} else {
    $response .= "9999";
}
$response .= ":{$page}0:".count($levelResult);

//and finally...
echo $response;
?>
