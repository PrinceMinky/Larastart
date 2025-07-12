<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KanbanCard extends Model
{
    use HasFactory;
    
    protected $casts = [
        'badges' => 'array',
        'due_at' => 'datetime',
    ];

    /**
     * Creates a URL attribute
     */
    public function getUrlAttribute()
    {
        return route('admin.kanban_card', [
            'boardSlug' => $this->board->slug,
            'columnSlug' => $this->column->slug,
            'cardId' => $this->id,
        ]);
    }

    /**
     * Creates a Display Name attribute used for links
     */
    public function getDisplayNameAttribute()
    {
        return $this->title;
    }

    public function column()
    {
        return $this->belongsTo(KanbanColumn::class, 'column_id')->withDefault();
    }

    public function board()
    {
        return $this->hasOneThrough(
            KanbanBoard::class,   
            KanbanColumn::class,  
            'id',                 
            'id',                 
            'column_id',          
            'board_id'            
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_user_id')->withDefault();
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
