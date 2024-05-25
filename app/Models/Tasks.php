<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tasks extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'user_id',
        'group_id',
        'completed_at',
        'deleted_at'
    ];

    public function group() {
        return $this->belongsTo(Groups::class);
    }
}
