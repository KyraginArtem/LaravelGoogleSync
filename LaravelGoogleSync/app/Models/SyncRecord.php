<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyncRecord extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    public function scopeAllowed($query)
    {
        return $query->where('status', 'Allowed');
    }

}
