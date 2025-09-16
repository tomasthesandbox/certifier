<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'type_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'type' => 'string',
        'type_id' => 'integer'
    ];

    public static $rules = [
        'user_id' => 'nullable|integer',
        'type' => 'required|string|max:255',
        'type_id' => 'nullable|integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
