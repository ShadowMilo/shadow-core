<?php

// modernized some stuff. kul

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Support\MainLib;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class levelload extends Controller
{
    public function index(Request $request)
    {
        // secrer
        if ($request->input('secret') !== 'Wmfd2893gb7') {
            return response('-1, not the secret')->header('Content-Type', 'text/plain');
        }

        // levelid
        if (! $request->has('levelID')) {
            return response('-1, give level id pls')->header('Content-Type', 'text/plain');
        }

        $levelID = $request->input('levelID');

        // ShadowMilo was here.
        $inc = intval($request->input('inc'));

        if ($inc == 1) {
            DB::table('levels')
                ->where('levelID', $levelID)
                ->increment('downloads');
        }

        // sxoreistrendingmoreueha
        DB::table('levels')
            ->where('levelID', $levelID)
            ->increment('trendingScore');

        // Xan was here.
        $level = DB::table('levels')->where('levelID', $levelID)->first();
        $path = base_path("levels/$levelID");

        // strinf
        if (base_Path("levels/{$levelID}")) {
            $levelstring = file_get_contents($path);
        } else {
            return response('-1, not a level')->header('Content-Type', 'text/plain');
        }

        // levelobject
        $description = MainLib::base64url_decode($level->description);

        $response = "1:{$level->levelID}:2:{$level->name}:3:{$description}:4:$levelstring:5:{$level->version}:6:{$level->userID}:10:{$level->downloads}:14:{$level->likes}:15:{$level->length}";

        return response($response)->header('Content-Type', 'text/plain');
    }
}
