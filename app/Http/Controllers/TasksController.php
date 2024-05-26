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
        /*$tasks = Tasks::all();
        return response()->json($tasks, 200);*/

        $tasks = Tasks::all();

        $today = Carbon::today();

        // Separar as tarefas em diferentes categorias
        $tasksDueTodayOrNoDate = $tasks->filter(function ($task) use ($today) {
            return is_null($task->conclusion_date) || $task->conclusion_date->isSameDay($today);
        });

        $upcomingTasks = $tasks->filter(function ($task) use ($today) {
            return !is_null($task->conclusion_date) && $task->conclusion_date->isAfter($today);
        });

        $completedTasks = $tasks->filter(function ($task) {
            return $task->completed == '1';
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
        $task = Tasks::create($request->all());
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
}
