<?php
include "incl/connection.php";
include "incl/config.php";

// check secret
if (!isset($_POST["secret"]) || $_POST["secret"] !== "Wmfd2893gb7") {
    exit("-1, thats not the secret silly");    
}

if (!isset($_POST["levelID"]) || !is_numeric($_POST["levelID"])) {
    exit("-1, please supply a valid level ID");
}

if (!isset($_POST["rating"]) || !is_numeric($_POST["rating"])) {
    exit("-1, please supply a valid rating");
}

$levelID = $_POST["levelID"];
$rating = $_POST["rating"];

// insert the rating into the database
$query = $conn->prepare("INSERT INTO nonModSends (levelID, rating) VALUES ("$levelID", "$rating")");
$query->execute();

echo "1"; // success
?>