<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::with('task_groups')->where('user_id', auth()->user()->id)->get();
        $today = Carbon::now()->setTimezone('America/Sao_Paulo');

        $tasks->each(function($task) {
            Log::info('Task ID: ' . $task->id . ' Group: ' . json_encode($task->group));
        });

        $tasksDueTodayOrNoDate = $tasks->filter(function ($task) use ($today) {
            $taskDateTime = $task->conclusion_date ? Carbon::parse($task->conclusion_date) : null;
            if ($task->conclusion_time) {
                $taskDateTime->setTimeFromTimeString($task->conclusion_time);
            }

            return (is_null($task->conclusion_date) && !$task->completed) ||
                ($taskDateTime && $taskDateTime->isSameDay($today) && !$taskDateTime->isPast()) &&
                !$task->completed;
        });

        $upcomingTasks = $tasks->filter(function ($task) use ($today) {
            if (!$task->conclusion_date) {
                return false;
            }

            $taskDateTime = Carbon::parse($task->conclusion_date);
            if ($task->conclusion_time) {
                $taskDateTime->setTimeFromTimeString($task->conclusion_time);
            }

            return $taskDateTime->isAfter($today) && !$taskDateTime->isSameDay($today) && !$task->completed;
        });

        $overdueTasks = $tasks->filter(function ($task) use ($today) {
            if (!$task->conclusion_date) {
                return false;
            }

            $taskDateTime = Carbon::parse($task->conclusion_date);
            if ($task->conclusion_time) {
                $taskDateTime->setTimeFromTimeString($task->conclusion_time);
            }

            return $taskDateTime->isPast() && !$task->completed;
        });

        $completedTasks = $tasks->filter(function ($task) {
            return $task->completed == '1';
        });

        if ($tasksDueTodayOrNoDate->isEmpty() && $upcomingTasks->isEmpty() && $overdueTasks->isEmpty() && $completedTasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found'], 404);
        }

        $response = [
            'today_tasks' => $tasksDueTodayOrNoDate->values(),
            'upcoming_tasks' => $upcomingTasks->values(),
            'overdue_tasks' => $overdueTasks->values(),
            'completed_tasks' => $completedTasks->values(),
        ];

        return response()->json($response, 200);
    }


    /**
     * Retornando em formato pt-br
     */
    /*public function index()
    {
        $tasks = Task::with('task_groups')->where('user_id', auth()->user()->id)->get();
        $today = Carbon::now()->setTimezone('America/Sao_Paulo');

        $tasks->each(function($task) {
            Log::info('Task ID: ' . $task->id . ' Group: ' . json_encode($task->group));
        });

        $tasksDueTodayOrNoDate = $tasks->filter(function ($task) use ($today) {
            $taskDateTime = $task->conclusion_date ? Carbon::parse($task->conclusion_date) : null;
            if ($task->conclusion_time) {
                $taskDateTime->setTimeFromTimeString($task->conclusion_time);
            }

            return (is_null($task->conclusion_date) && !$task->completed) ||
                ($taskDateTime && $taskDateTime->isSameDay($today) && !$taskDateTime->isPast()) &&
                !$task->completed;
        });

        $upcomingTasks = $tasks->filter(function ($task) use ($today) {
            if (!$task->conclusion_date) {
                return false;
            }

            $taskDateTime = Carbon::parse($task->conclusion_date);
            if ($task->conclusion_time) {
                $taskDateTime->setTimeFromTimeString($task->conclusion_time);
            }

            return $taskDateTime->isAfter($today) && !$taskDateTime->isSameDay($today) && !$task->completed;
        });

        $overdueTasks = $tasks->filter(function ($task) use ($today) {
            if (!$task->conclusion_date) {
                return false;
            }

            $taskDateTime = Carbon::parse($task->conclusion_date);
            if ($task->conclusion_time) {
                $taskDateTime->setTimeFromTimeString($task->conclusion_time);
            }

            return $taskDateTime->isPast() && !$task->completed;
        });

        $completedTasks = $tasks->filter(function ($task) {
            return $task->completed == '1';
        });

        if ($tasksDueTodayOrNoDate->isEmpty() && $upcomingTasks->isEmpty() && $overdueTasks->isEmpty() && $completedTasks->isEmpty()) {
            return response()->json(['message' => 'No tasks found'], 404);
        }

        // Formatar datas no formato brasileiro antes de enviar como resposta JSON
        $tasksDueTodayOrNoDate = $tasksDueTodayOrNoDate->map(function ($task) {
            $task->conclusion_date = $task->conclusion_date ? Carbon::parse($task->conclusion_date)->format('d/m/Y') : null;
            return $task;
        });

        $upcomingTasks = $upcomingTasks->map(function ($task) {
            $task->conclusion_date = $task->conclusion_date ? Carbon::parse($task->conclusion_date)->format('d/m/Y') : null;
            return $task;
        });

        $overdueTasks = $overdueTasks->map(function ($task) {
            $task->conclusion_date = $task->conclusion_date ? Carbon::parse($task->conclusion_date)->format('d/m/Y') : null;
            return $task;
        });

        // Montar a resposta JSON com as tarefas formatadas
        $response = [
            'today_tasks' => $tasksDueTodayOrNoDate->values(),
            'upcoming_tasks' => $upcomingTasks->values(),
            'overdue_tasks' => $overdueTasks->values(),
            'completed_tasks' => $completedTasks->values(),
        ];

        return response()->json($response, 200);
    }*/




    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$task = Tasks::create($request->all());
        $task = new Task();
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
        $task = Task::find($id);
        return response()->json($task, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->update($request->all());
        return response()->json($task, 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);

        if ($task->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $task->delete();

        $response = [
            'message' => 'Task deleted',
            'id' => $id
        ];

        return response()->json($response, 200);
    }


    public function completeTask($id)
    {
        $task = Task::find($id);

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
        $task = Task::find($id);

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
