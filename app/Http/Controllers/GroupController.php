<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::all()->where('user_id', auth()->user()->id);

        if ($groups->isEmpty()) {
            return response()->json(['message' => 'No groups found'], 404);
        }

        return response()->json($groups, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $group = new Group();
        $group->name = $request->name;
        $group->description = $request->description;
        $group->user_id = auth()->user()->id;
        $group->save();
        return response()->json($group);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $group = Group::find($id)->where('user_id', auth()->user()->id);
        return response()->json($group);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $groups)
    {
        $group = new Group();

        if ($group->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $group->name = $request->name;
        $group->description = $request->description;
        $group->user_id = auth()->user()->id;
        $group->update();
        return response()->json($group);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $groups)
    {
        $group = Group::find($groups->id);

        if ($group->user_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $group->delete();

        $response = [
            'message' => 'Group deleted',
            'id' => $group->id
        ];

        return response()->json($response, 200);
    }
}
