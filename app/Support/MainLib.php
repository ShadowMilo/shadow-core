<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

class MainLib
{
    // url safe base64 (j)
    public static function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public static function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }

    public static function getUserID($udid, $userName = 'User')
    {
        /**
         * Check if the user already exists,
         * otherwise create a new user
         */
        $query = DB::select('SELECT * FROM GDPSUsers WHERE udid = ?', [$udid]);
        if (count($query) > 0) {
            $userID = $query[0]->userID;
        } else {
            // create a new user
            DB::insert('INSERT INTO GDPSUsers (udid, username) VALUES (?, ?)', [$udid, $userName]);
            $userID = DB::getPdo()->lastInsertId();
        }

        return $userID;
    }
}
