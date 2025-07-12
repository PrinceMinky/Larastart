<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KanbanColumn extends Model
{
    use HasFactory;
    /**
     * Creates a URL attribute
     */
    public function getUrlAttribute()
    {
        return route('admin.kanban_board', [
            'slug' => $this->board->slug ?? null
        ]);
    }

    /**
     * Creates a Display Name attribute used for links
     */
    public function getDisplayNameAttribute()
    {
        return $this->title;
    }

    public function board()
    {
        return $this->belongsTo(KanbanBoard::class, 'board_id')->withDefault();
    }
    
    public function cards()
    {
        return $this->hasMany(KanbanCard::class, 'column_id')->orderBy('position');
    }
}
