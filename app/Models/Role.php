<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'label'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'id' => 'integer',
        'label' => 'string'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'label' => 'string'
        ];
    }

    public static $rules = [
        'label' => 'required|string|max:191'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
