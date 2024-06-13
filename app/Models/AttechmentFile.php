<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttechmentFile extends Model
{
    use HasFactory;
    protected $fillable = ['note_id', 'File' ];

    protected $appends = [
        "full_doc_url"
    ];
    public function getFullDocUrlAttribute()
    {
        return url('storage/'. $this->File);
    }
}
