<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Task extends Model
{
    protected $fillable = [
        'title', 'description', 'status', 'priority', 'assigned_to', 'created_by', 'due_date',
    ];

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
