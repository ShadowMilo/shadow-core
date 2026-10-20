<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\exploit;
use App\Support\MainLib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class uploadlevel extends Controller
{
    public function index(Request $request)
    {
        // secret
        if (! $request->has('secret') || $request->input('secret') != 'Wmfd2893gb7') {
            return response('-1, not the secret')->header('Content-Type', 'text/plain');
        }

        // levelid
        if (! $request->has('levelID')) {
            return response('-1, give level id')->header('Content-Type', 'text/plain');
        }

        // udid
        if (! $request->has('udid')) {
            return response('-1, give udid')->header('Content-Type', 'text/plain');
        }

        $gameVersion = exploit::charclean($request->input('gameVersion'));
        $udid = exploit::clean($request->input('udid'));
        $userName = exploit::clean($request->input('userName'));
        $userID = MainLib::getUserID($udid, $userName);

        $levelID = exploit::number($request->input('levelID'));
        $levelName = exploit::clean($request->input('levelName'));
        $levelDesc = MainLib::base64url_encode($request->input('levelDesc'));
        $levelString = $request->input('levelString');
        $levelVersion = exploit::number($request->input('levelVersion'));
        $levelLength = exploit::number($request->input('levelLength'));
        $audioTrack = exploit::number($request->input('audioTrack'));

        // hash the ip
        $ipHash = hash('sha256', $request->ip().config('app.key'));

        // if the level doesnt exist (dont update)
        if ($levelID == 0) {
            // update score for trending
            DB::update('UPDATE levels SET trendingScore = trendingScore - 10 WHERE trendingScore > -10');

            // insert
            DB::insert('INSERT INTO levels (name, udid, song, gameVersion, version, description, userID, username, length, ipHash) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                $levelName,
                $udid,
                $audioTrack,
                $gameVersion,
                $levelVersion,
                $levelDesc,
                $userID,
                $userName,
                $levelLength,
                $ipHash,
            ]);

            // get the id
            $newLevelID = DB::getPdo()->lastInsertId();

            // save to file
            file_put_contents(base_path("levels/$newLevelID"), $levelString);

            return response($newLevelID)->header('Content-Type', 'text/plain');
            // if it does exist:::::::::::::::::::::::::::::::::::::::
        } else {
            // it does exist so were updating
            // check if they actually own it
            // using their HASHED ip because we arent storing raw ips
            $existingLevel = DB::select('SELECT udid, ipHash FROM levels WHERE levelID = ?', [$levelID]);

            if (empty($existingLevel)) {
                return response('-1, level not found')->header('Content-Type', 'text/plain');
            }

            if ($existingLevel[0]->udid !== $udid || $existingLevel[0]->ipHash !== $ipHash) {
                return response("-1, you don't own this level")->header('Content-Type', 'text/plain');
            }

            DB::update('UPDATE levels SET version = ?, length = ? WHERE levelID = ?', [
                $levelVersion,
                $levelLength,
                $levelID,
            ]);

            // overwrite
            file_put_contents(base_path("levels/$levelID"), $levelString);

            return response($levelID)->header('Content-Type', 'text/plain');
        }
    }
}
