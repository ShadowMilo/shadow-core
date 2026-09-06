<?php
// require not include dumazz
require __DIR__ . "/../incl/connection.php";
require_once __DIR__ . "/../incl/password.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $levelID = $_POST['levelID'] ?? "";
    $stars = $_POST['stars'] ?? "";
    $diff = $_POST['diff'] ?? "";
    $featureScore = $_POST['featureScore'] ?? "";
    $featureType = $_POST['featureType'] ?? "";
    $password = $_POST['password'] ?? "";
} else {
    $levelID = "";
    $stars = "";
    $diff = "";
    $featureScore = "";
    $featureType = "";
    $password = "";
}
?>
<!DOCTYPE html>
<html lang="en">

    <body>
        <form action="rateLevel.php" method="POST">
            <label for="levelID">Level ID:</label>
            <input type="number" id="levelID" name="levelID" value="<?php echo $levelID; ?>"><br>
            <label for="stars">Stars:</label>
            <input type="number" id="stars" name="stars" value="<?php echo $stars; ?>"><br>
            <label for="diff">Difficulty: (10=easy, 20=normal, 30=hard, 40=harder, 50=insane)</label>
            <input type="number" id="diff" name="diff" value="<?php echo $diff; ?>"><br>
            <label for="featureScore">Feature Score: (doesnt matter if not featured)</label>
            <input type="number" id="featureScore" name="featureScore" value="<?php echo $featureScore; ?>"><br>
            <label for="featureType">Featured: (1=yes, 0=no)</label>
            <input type="number" id="featureType" name="featureType" value="<?php echo $featureType; ?>"><br>
            <label for="password">Password:</label>
            <input type="text" id="password" name="password" value="<?php echo $password; ?>"><br>
            <input type="submit" value="Rate Level">
        </form>
    </body>
</html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
//check password
if ($password != $adminPassword) {
    echo "Incorrect password. Refresh page to try again.";
    exit;
} elseif ($featureType < 0 || $featureType > 1) {
    // feature type invalid
    echo "Please enter 0 (not featured) or 1 (featured). Refresh page to try again.";
    exit;
} elseif ($diff != 10 && $diff != 20 && $diff != 30 && $diff != 40 && $diff != 50) {
    echo "Invalid difficulty. Refresh page to try again.";
    exit;
}
$validateLevelID = $conn->prepare("SELECT COUNT(*) FROM levels WHERE levelID = :levelID");
$validateLevelID->bindParam(':levelID', $levelID);
$validateLevelID->execute();
$levelCheck = $validateLevelID->fetchColumn();
if ($levelCheck < 1) {
    echo "Not a level on the GDPS. Refresh page to try again.";
    exit;
} elseif ($levelCheck > 1) {
    echo "oh god theres a duplicate level id this should never happen.";
    echo "report bug at https://github.com/ShadowMilo/shadow-core/issues";
    exit;
} else {
    // good password, valid feature type, level exists, rate the level.
    $query = $conn->prepare("UPDATE levels SET stars = :stars, diff = :diff, featureScore = :featureScore, featureType = :featureType WHERE levelID = :levelID");
    $query->bindParam(':levelID', $levelID);
    $query->bindParam(':stars', $stars);
    $query->bindParam(':diff', $diff);
    $query->bindParam(':featureScore', $featureScore);
    $query->bindParam(':featureType', $featureType);
    $query->execute();
    $getLevelName = $conn->prepare("SELECT name FROM levels WHERE levelID = :levelID");
    $getLevelName->bindParam(':levelID', $levelID);
    $getLevelName->execute();
    $levelName = $getLevelName->fetchColumn();
    if ($featureType == 1) {
        // say it was featured
        echo "Level $levelName (ID: $levelID) featured with star count $stars and feature score $featureScore.";
    } else {
        // not featured
        echo "Level $levelName (ID: $levelID) rated with star count $stars.";
    }
}
}
?>
