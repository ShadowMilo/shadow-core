<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class MainLib
{
  // URL-safe Base64 Encode/Decode
  public static function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
  }
  public static function base64url_decode($data) {
    return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
  }


  public static function getUserID($udid, $userName = "User") {

    /**
     * Check if the user already exists,
     * otherwise create a new user in the
     * 'users' table
     */
    $query = DB::select("SELECT * FROM users WHERE udid = ?", [$udid]);
    if (count($query) > 0) {
      // Note: In raw PDO, fetchColumn() would get the first column of the row.
      // Assuming the first column in your users table is something like userID or id.
      // If your table's primary key is different, adjust the ->id below.
      $userID = $query[0]->id ?? $query[0]->userID ?? null; 
    } else {
      // Create a new user
      DB::insert("INSERT INTO users (udid, username) VALUES (?, ?)", [$udid, $userName]);
      $userID = DB::getPdo()->lastInsertId();
    }
    return $userID;
  }
}