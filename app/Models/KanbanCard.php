<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function getDueStatusAttribute(): ?array
    {
        if (!$this->due_at) {
            return null;
        }

        $dueDate = Carbon::parse($this->due_at);
        $now = now();

        $isDueSoon = $dueDate->isFuture() && $dueDate->diffInHours($now) <= 24;
        $isPastDue = $dueDate->isPast();

        $badgeColor = $isPastDue ? 'red' : ($isDueSoon ? 'yellow' : 'default');

        return [
            'color' => $badgeColor,
            'text' => $dueDate->diffForHumans(),
            'raw' => $dueDate,
        ];
    }
}
