<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
class TaskController extends Controller
{
    public function index(){
        $tasks = Task::all();
        return view('task',compact('tasks'));
    }

    public function store(Request $request){

        $task = Task::create([
            'task' => $request->task,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
        ]);
        if($task){
            $html = $this->getTaskHtml($task);
            return response()->json(['status' => true,'task' => $html]);
        }
        return response()->json(['status' => false,'task' => '']);
    }

    public function update(Request $request, $id){
        Task::where('id',$id)->update([
            'task' => $request->task,
            'due_date' => $request->due_date,
            'priority' => $request->priority,
        ]);
        $task = Task::find($id);
        if($task){
            return response()->json(['status' => true,'color' => $this->getTaskColor($task,true)]);
        }
        return response()->json(['status' => false]);
        # code...
    }
    public function edit($id){

        $task = Task::find($id);
        if($task){
            $html = '<input id="task-id" type="hidden" value="'.$id.'" style="display:none">
                <p>Task</p>
                <input class="form-control" name="task" id="task" value="'.$task->task.'">
                <p>Due Date</p>
                <input name="due_date" type="datetime-local" class="form-control" id="due-date" value="'.$task->due_date.'">
                <p>Priority</p>
                <select class="form-control" name="priority" id="priority" value="'.$task->priority.'">
                    <option value="low">Low</option>
                    <option value="medium">Medium</option>
                    <option value="testing">Testing</option>
                    <option value="high">High</option>
                </select>';
            return response()->json(['status' => true,'task' => $html]);
        }
        return response()->json(['status' => false,'task' => '']);
    }

    public function destroy($id){
        Task::destroy($id);
        return response()->json(['status' => true]);

    }

    public function getTaskHtml($task){
        return '<div>
                <div class="card">
                    <div class="row">
                        <div class="col-md-10 showed-values">
                            '.$task->due_date.'<br>
                            <b>'.$task->task.'</b>
                        </div>
                        <div class="col-md-2 options">
                            <a> <i class="fas fa-edit" onclick="editTask(this,'.$task->id.')></i></a>
                            <a> <i class="fas fa-trash" onclick="deleteTask(this,'.$task->id.')></i></a>
                        </div>
                    </div>
                    <div style="'.$this->getTaskColor($task).'"></div>
                </div>
            </div>';

    }
    private function getTaskColor($task,$onlyBG = false){
        $css = '';
        $bg = '';

        if($task->priority == 'low' ){
            $bg = 'green';
            $css = 'height: 6px;border-radius: 0 0 5px 5px;background-color:green';
        } else if($task->priority == 'medium' ){
            $bg = 'yellow';
            $css = 'height: 6px;border-radius: 0 0 5px 5px;background-color:yellow';
        } else if($task->priority == 'testing' ){
            $bg = 'yellow';
            $css = 'height: 6px;border-radius: 0 0 5px 5px;background-color:yellow';
        } else if($task->priority == 'high' ){
            $bg = 'red';
            $css = 'height: 6px;border-radius: 0 0 5px 5px;background-color:red';
        }
        if($onlyBG){
            return $bg;
        }
        return $css;
    }

}
