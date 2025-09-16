<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'failed_attempts',
        'date_of_use'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_id' => 'integer',
            'code' => 'string',
            'failed_attempts' => 'integer',
            'date_of_use' => 'timestamp'
        ];
    }

    public static $rules = [
        'user_id' => 'required|integer|min:1|exists:users,id',
        'code' => 'required|string',
        'failed_attempts' => 'required|integer',
        'date_of_use' => 'nullable|date_format:Y-m-d H:i:s'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
