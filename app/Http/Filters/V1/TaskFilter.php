<?php

namespace App\Http\Filters\V1;

class TaskFilter extends QueryFilter {
    protected $sortable = [
        'status',
        'dueDate' => 'due_date',
        'notes',
        'priority'
    ];

    public function due_date($value) {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('dueDate', $dates);
        }

        return $this->builder->whereDate('dueDate', $value);
    }
    public function notes($value) {
        return $this->builder->whereHas('notes');
    }
    public function status($value) {
        return $this->builder->where('status',  $value );
    }

    public function priority($value) {
        
        return $this->builder->where('priority',  $value);
    }

   

    
}