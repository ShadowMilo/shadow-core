<?php
//shadow melon im copying your comments word for word
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class getlevel extends Controller
{
    public function wrongMethod()
    {
        return response('wrong method', 405)->header('Content-Type', 'text/plain');
    }

    public function index(Request $request)
   
    {
         $realLevelCount = true;
        // check secret
        if (!isset($request["secret"]) || $request["secret"] !== "Wmfd2893gb7") {
            return response("-1, thats not the secret silly")->header('Content-Type', 'text/plain');
        }
        if (!isset($request["type"])) {
            return response("-1, please supply a search type sir")->header('Content-Type', 'text/plain');
        }

        // params from client
        $page = isset($request["page"]) ? $request["page"] : 0;
        $type = $request["type"];
        $str = isset($request["str"]) ? $request["str"] : "";
        $diff = isset($request["diff"]) ? $request["diff"] : "";

        // what do these even do?
        $where = null;
        $order = null;

        // types of searching oh joy
        switch ($type) {
            case 0:
                // they searching a name
                if (is_numeric($str)) {
                    // oh wait its an id, so we search by id instead
                    $where = "WHERE levelID LIKE '{$str}%'";
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
                    return response("-1, user ids are numeric dumdum")->header('Content-Type', 'text/plain');
                }
                break;
            default:
                return response("-1, thats not a search type silly")->header('Content-Type', 'text/plain');
        }

        // difficulty filters
        $diffSql = null;
        if ($diff != "-" && $diff != "") {
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

        // this probably fetches the levels
        $levelResult = DB::select("SELECT * FROM levels {$where} {$diffSql} {$order} LIMIT 10 OFFSET {$page}");

        // are there even levels?
        if (empty($levelResult)) {
            return response("-1, theres no levels here")->header('Content-Type', 'text/plain');
        }

        // how many levels?
        if ($realLevelCount) {
            $amountOfLevels = DB::select("SELECT COUNT(*) FROM levels $where $diffSql")[0]->{'COUNT(*)'};
        }

        // create the response
        // gd is stupid so this is weird
        $response = "";

        // level object
        // why is this in the php and not in the client
        $levelObject = null;
        $creatorObject = null;
        foreach ($levelResult as $row) {
            // i guess we're doing fractions or something????
            if ($row->diff == 0) {
                $difficultyDenominator = 0;
            } else {
                $difficultyDenominator = 10;
            }

            // parameter time :)
            $levelObject .= "1:{$row->levelID}:2:{$row->name}:3:{$row->description}:5:{$row->version}:6:{$row->userID}:8:{$difficultyDenominator}:9:{$row->diff}:10:{$row->downloads}:11:0:12:{$row->song}:13:{$row->gameVersion}:14:{$row->likes}:15:{$row->length}|";
            $creatorObject .= "{$row->userID}:{$row->username}|";
        }
        $levelObject = substr($levelObject, 0, -1);
        $creatorObject = substr($creatorObject, 0, -1);
        $response .= "{$levelObject}#{$creatorObject}#";
        // allat for *one level*
        // i hate gd sometimes

        // Page Object
        // whyyyyyyyy
        if ($realLevelCount) {
            $response .= "{$amountOfLevels}";
        } else {
            $response .= "9999";
        }
        $response .= ":{$page}0:".count($levelResult);

        // and finally...
        return response($response)->header('Content-Type', 'text/plain');
    }
}