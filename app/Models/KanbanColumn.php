<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KanbanColumn extends Model
{
    use HasFactory;
    
    protected $fillable = ['title', 'slug', 'position', 'board_id'];

    public function board()
    {
        return $this->belongsTo(KanbanBoard::class, 'board_id');
    }
    
    public function cards()
    {
        return $this->hasMany(KanbanCard::class, 'column_id')->orderBy('position');
    }
}