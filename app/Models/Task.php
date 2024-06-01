<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id',
        'group_id',
        'completed_at',
        'deleted_at'
    ];

    /*protected $rules = $request->validate([
        'task' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'required|date_format:Y-m-d',
        'due_time' => 'required|date_format:H:i',
    ]);*/


    public function group() {
        return $this->belongsTo(Groups::class);
    }
}
