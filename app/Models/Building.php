<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'country',
        'status',
        'completion_year',
        'height',
        'floors',
        'material',
        'function',
        'user_id',
    ];

    protected $casts = [
        'completion_year' => 'integer',
        'floors' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
