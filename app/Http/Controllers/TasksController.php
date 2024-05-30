<?php

namespace App\Http\Controllers;

use App\Models\tasks;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Tasks::all();
        $today = Carbon::now();

        // Separar as tarefas em diferentes categorias
        $tasksDueTodayOrNoDate = $tasks->filter(function ($task) use ($today) {
            return (is_null($task->conclusion_date) && !$task->completed) ||
                ($task->conclusion_date && Carbon::parse($task->conclusion_date)->isSameDay($today) && !$task->completed);
        })->map(function ($task) {
            $task->conclusion_date = $task->conclusion_date ? Carbon::parse($task->conclusion_date)->format('d/m') : null;
            $task->conclusion_time = $task->conclusion_time ? Carbon::parse($task->conclusion_time)->format('H:i') : null;
            return $task;
        });

        $upcomingTasks = $tasks->filter(function ($task) use ($today) {
            return $task->conclusion_date && Carbon::parse($task->conclusion_date)->isAfter($today);
        })->map(function ($task) {
            $task->conclusion_date = $task->conclusion_date ? Carbon::parse($task->conclusion_date)->format('d/m') : null;
            $task->conclusion_time = $task->conclusion_time ? Carbon::parse($task->conclusion_time)->format('H:i') : null;
            return $task;
        });

        $completedTasks = $tasks->filter(function ($task) {
            return $task->completed == '1';
        })->map(function ($task) {
            $task->conclusion_date = $task->conclusion_date ? Carbon::parse($task->conclusion_date)->format('d/m') : null;
            $task->conclusion_time = $task->conclusion_time ? Carbon::parse($task->conclusion_time)->format('H:i') : null;
            return $task;
        });

        $response = [
            'today_tasks' => $tasksDueTodayOrNoDate->values(),
            'upcoming_tasks' => $upcomingTasks->values(),
            'completed_tasks' => $completedTasks->values(),
        ];

        return response()->json($response, 200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$task = Tasks::create($request->all());
        $task = new Tasks();
        $task->title = $request->task;
        $task->description = $request->description;
        $task->conclusion_date = $request->due_date;
        $task->conclusion_time = $request->due_time;
        $task->user_id = auth()->user()->id;
        $task->save();

        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Tasks::find($id);
        return response()->json($task, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Tasks::find($id);
        $task->update($request->all());
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Tasks::find($id);
        $task->softDelete();
        return response()->json(null, 204);
    }


    public function completeTask($id)
    {
        $task = Tasks::find($id);

        if ($task->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task->completed = true;
        $task->status = 'completed';
        $task->completed_at = Carbon::now();
        $task->save();
        return response()->json($task, 200);
    }


    public function uncompleteTask($id)
    {
        $task = Tasks::find($id);

        if ($task->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task->completed = false;
        $task->status = 'pending';
        $task->completed_at = null;
        $task->save();
        return response()->json($task, 200);
    }

}
