<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;
    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
