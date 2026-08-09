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
    case 3:
        // trending yay
        $order = "ORDER BY trendingScore DESC";
        $where = "WHERE trendingScore > 9";
        break;
    case 6:
        // featured tab (written by me)
        $order = "ORDER BY featureScore DESC";
        $where = "WHERE featureType >= 1";
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
