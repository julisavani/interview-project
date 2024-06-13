<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'description', 'startDate', 'dueDate' , 'status' , 'priority' , 'user_id' ];
    

    public function scopeFilter(Builder $builder, QueryFilter $filters) {
        return $filters->apply($builder);
    }
   
    public function notes() : HasMany {
        return $this->hasMany(Note::class , 'task_id')->with('attechmentfile');
    }
}
