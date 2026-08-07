<?php
class GDPS {
  // URL-safe Base64 Encode/Decode
  public static function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }
  public static function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
  }


  public static function getUserID($udid, $userName = "User") {
    include "connection.php";

    /**
     * Check if the user already exists,
     * otherwise create a new user in the
     * 'users' table
     */
    $query = $conn->prepare("SELECT * FROM gjUsers WHERE udid = :udid");
    $query->execute([":udid" => $udid]);
    if ($query->rowcount() > 0) {
      $userID = $query->fetchColumn();
    } else {
      // Create a new user
      $query = $conn->prepare("INSERT INTO gjUsers (udid, userName) VALUES (:udid, :userName)");
      $query->execute([":udid" => $udid, ":userName" => $userName]);
      $userID = $conn->lastInsertId();
    }
    return $userID;
  }
}
?>
