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
        return response()->json($groups);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Group $groups)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $groups)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $groups)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $groups)
    {
        //
    }
}
