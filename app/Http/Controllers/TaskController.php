<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\TodoList;
use App\Task;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function store(Request $request, $todolistId)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $todolist = TodoList::find($todolistId);
        $task = $todolist->tasks()->create($request->all());

        return view('tasks.item', compact('task'));
    }

    public function update(Request $request, $todolistId, $id)
    {
        $task = Task::findORFail($id);
        $task->completed_at = (($request['completed'] == 'true') ? Carbon::now() : NULL);
        $success = $task->update();
        echo $success;
    }

    public function destroy($todolistId, $id)
    {
        $task = Task::find($id);
        $success = $task->delete();
        return $task;
    }
}
