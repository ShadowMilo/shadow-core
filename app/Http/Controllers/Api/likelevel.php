<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class likelevel extends Controller
{
    public function index(Request $request)
    {
        // secret check
        if (!$request->has('secret') || $request->input('secret') !== "Wmfd2893gb7") {
            return response("-1, not the secret")->header('Content-Type', 'text/plain');
        }

        // get level id
        $levelID = intval($request->input('levelID'));

        // hash the ip
        $ipHash = hash('sha256', $request->ip() . config('app.key'));

        // check if they already liked it (type 1 = like)
        $alreadyLiked = DB::table('actions')
            ->where('type', 1)
            ->where('ipHash', $ipHash)
            ->where('val1', $levelID)
            ->exists();

        if ($alreadyLiked) {
            return response("-1, gurt.")->header('Content-Type', 'text/plain');
        }

        // update db
        DB::table('levels')
            ->where('levelID', $levelID)
            ->increment('likes');

        // and now we update trending
        DB::table('levels')
            ->where('levelID', $levelID)
            ->increment('trendingScore', 5);

        // log the action
        DB::table('actions')->insert([
            'type' => 1,
            'ipHash' => $ipHash,
            'val1' => $levelID,
            'val2' => null,
            'val3' => null,
            'val4' => null,
            'createdAt' => time(),
        ]);

        return response("1")->header('Content-Type', 'text/plain');
    }
}