<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;

class FormationController extends Controller
{
    public function index()
    {
        $formations = auth()->user()->formations;

        return response()->json([
            'success' => true,
            'data' => $formations
        ]);
    }

    public function show($id)
    {
        $formation = auth()->user()->formations()->find($id);

        if (!$formation) {
            return response()->json([
                'success' => false,
                'message' => 'formation not found '
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $formation->toArray()
        ], 400);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'nombreDeJours' => 'required',
            'tarifsParJours' => 'required',
            'nombreDeParticipant' => 'required'
        ]);

        $formation = new Formation();
        $formation->title = $request->title;
        $formation->description = $request->description;
        $formation->nombreDeJours = $request->nombreDeJours;
        $formation->tarifsParJours = $request->tarifsParJours;
        $formation->nombreDeParticipant = $request->nombreDeParticipant;

        if (auth()->user()->formations()->save($formation))
            return response()->json([
                'success' => true,
                'data' => $formation->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'formation not added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $formation = auth()->user()->formations()->find($id);

        if (!$formation) {
            return response()->json([
                'success' => false,
                'message' => 'formation not found'
            ], 400);
        }

        $updated = $formation->fill($request->all())->save();


        if ($updated)
            return response()->json([
                'success' => true
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'formation can not be updated'
            ], 500);
    }

    public function destroy($id)
    {
        $formation = auth()->user()->formations()->find($id);

        if (!$formation) {
            return response()->json([
                'success' => false,
                'message' => 'formation not found'
            ], 400);
        }

        if ($formation->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'formation can not be deleted'
            ], 500);
        }
    }
}
