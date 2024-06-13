<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'note', 'task_id' ];

    public function task(): BelongsTo {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function attechmentfile(): HasMany 
    {
        return $this->hasMany(AttechmentFile::class , 'note_id' );
    }


}
