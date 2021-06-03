<?php

namespace App\Http\Controllers;

use App\Models\Quality;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QualityController extends Controller
{
    public function showQuality($id){
        $quality = auth()->user()->formations()->find($id)->quality;

        if (!$quality) {
            return response()->json([
                'success' => false,
                'message' => 'quality not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $quality->toArray()
        ]);
    }

    public function addQuality(Request $request){

        $this->validate($request, [
            'preparation' => 'required',
            'organisation' => 'required',
            'deroulement' => 'required',
            'contenu' => 'required',
            'efficacite' => 'required',
            'avis' => 'required'
        ]);

        $formation = DB::table('formations')->where([
            ['title','=',$request->title_formation],
            ['user_id','=',auth()->user()->id]
        ])->first();


        $quality = new Quality();
        $quality->preparation = $request->preparation;
        $quality->organisation = $request->organisation;
        $quality->deroulement = $request->deroulement;
        $quality->contenu = $request->contenu;
        $quality->efficacite = $request->efficacite;
        $quality->avis = $request->avis;
        $quality->formation_id = $formation->id;
        $quality->save();


        return response()->json([
            'success' => true,
            'data' => $quality
        ]);

    }
}
