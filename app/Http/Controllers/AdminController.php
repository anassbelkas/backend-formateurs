<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showFormations($id)
    {
        $formations = User::find($id)->formations;

        return response()->json([
            'success' => true,
            'data' => $formations
        ]);
    }
}
