<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(){
        $tasks = \App\Models\Task::orderBy('is_done')->get();
        return view('tasks.index', ['tasks'=> $tasks]);
    }

    public function store(Request $request){
        $validate = $request->validate([
            'title' => 'required|max:255'
        ]);

        Task::create([
            'title' => $validate['title']
        ]);

        return redirect('/');
    }

    // public function toggle($id){
    //     $task = Task::findOrFail($id);
    //     $task -> is_done = !$task -> is_done;
    //     $task -> save();
    //     return redirect('/');

    // }

    public function update(Request $request, $id){
        $task = \App\Models\Task::findOrFail($id);

        if($request->has('is_done')){
            $task->is_done = $request->input('is_done') == '1' ? 1:0;
        }

        if($request->has('title')){
            $request -> validate([
                'title' => 'required|max:255',
            ]);
            $task->title = $request->input('title');
        }

        $task->save();
        return redirect('/');

    }

    public function destroy($id){
        Task::destroy($id);
        return redirect('/');
    }
}
