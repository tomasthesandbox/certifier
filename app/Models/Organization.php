<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'address',
        'image',
        'phone'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'address' => 'string',
            'image' => 'string',
            'phone' => 'string'
        ];
    }

    public static $rules = [
        'description' => 'required|string|max:191',
        'address' => 'required|string|max:191',
        'image' => 'required|string|max:191',
        'phone' => 'required|string|max:191'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
