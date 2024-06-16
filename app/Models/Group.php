<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'task_groups';

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'deleted_at'
    ];

    public function tasks() {
        return $this->hasMany(Task::class);
    }

}
