<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TodoController extends Controller
{
    public function index()
    {
        $todos = auth()->user()->todos;

        return response()->json([
            'success' => true,
            'data' => $todos
        ]);

    }



    public function store(Request $request)
    {

        $newTodo = new Todo;
        $newTodo->nameTodo = $request->nameTodo;
        $newTodo->completed = false;



        if (auth()->user()->todos()->save($newTodo))
            return response()->json([
                'success' => true,
                'data' => $newTodo->toArray()
            ]);
        else
            return response()->json([
                'success' => false,
                'message' => 'todo not added'
            ], 500);
    }

    public function update(Request $request, $id)
    {
        $todo = auth()->user()->todos()->find($id);

        if ($todo) {
            $todo->completed = $request->completed ? true : false;
            $todo->completed_at = $request->completed ? Carbon::now() : null;
            $todo->save();
            return $todo;
        }
        return  "todo not found.";
    }

    public function destroy($id)
    {
        $todo = auth()->user()->todos()->find($id);


        if ($todo) {
            $todo->delete();
            return "Todo successfully deleted.";
        }
        return "Todo not found.";
    }
}
