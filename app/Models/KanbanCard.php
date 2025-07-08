<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KanbanCard extends Model
{
    use HasFactory;
    
    public $fillable = ['title','description','position','badges','column_id','user_id','due_at','assigned_user_id'];

    protected $casts = [
        'badges' => 'array',
        'due_at' => 'datetime',
    ];

    public function column()
    {
        return $this->belongsTo(KanbanColumn::class, 'column_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'model', 'model_class', 'model_id');
    }
}
