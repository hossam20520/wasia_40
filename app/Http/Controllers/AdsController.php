<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ad;
class AdsController extends Controller
{
    //

    public function ads(){

       $ads =  Ad::all();

        $data = [
            'data' => $ads
        ];
        return response()->json($data, 200);
    }
}
