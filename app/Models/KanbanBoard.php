<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class KanbanBoard extends Model
{
    use HasFactory;

    protected $casts = [
        'badges' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($board) {
            if (empty($board->owner_id)) {
                $board->owner_id = Auth::id();
            }
        });
    }
    
    /**
     * Creates a URL attribute
     */
    public function getUrlAttribute()
    {
        return route('admin.kanban_board', [
            'slug' => $this->slug ?? null
        ]);
    }

    /**
     * Creates a Display Name attribute used for links
     */
    public function getDisplayNameAttribute()
    {
        return $this->title;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'kanban_board_user')->withTimestamps();
    }

    public function columns()
    {
        return $this->hasMany(KanbanColumn::class, 'board_id')->orderBy('position');
    }
}
