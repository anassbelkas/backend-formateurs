<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showFormations($id)
    {
        $type = auth()->user()->type;

        if($type == 1) {
            $formations = User::find($id)->formations;

            return response()->json([
                'success' => true,
                'data' => $formations
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'you are not admin'
            ], 500);
        }
    }



    public function destroyFormation($id, $idF)
    {
        $type = auth()->user()->type;

        if($type == 1) {
            $formation = User::find($id)->formations()->find($idF);

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
        }else{
            return response()->json([
                'success' => false,
                'message' => 'you are not admin'
            ], 500);
        }
    }
    public function showTasks($id)
    {
        $type = auth()->user()->type;

        if($type == 1) {
            $task = User::find($id)->todos;

            return response()->json([
                'success' => true,
                'data' => $task
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'you are not admin'
            ], 500);
        }
    }



    public function destroyTasks($id, $idT)
    {
        $type = auth()->user()->type;

        if($type == 1) {
            $task = User::find($id)->todos()->find($idT);

            if (!$task) {
                return response()->json([
                    'success' => false,
                    'message' => 'task not found'
                ], 400);
            }

            if ($task->delete()) {
                return response()->json([
                    'success' => true
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'task can not be deleted'
                ], 500);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'you are not admin'
            ], 500);
        }
    }
}
