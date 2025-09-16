<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'activities';

    protected $fillable = [
        'association_id',
        'name'
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
            'association_id' => 'integer',
            'name' => 'string'
        ];
    }

    public static $rules = [
        'association_id' => 'required|integer|min:1|exists:associations,id',
        'name' => 'required|string|max:255'
    ];

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function scoringRules()
    {
        return $this->hasMany(ScoringRule::class, 'activity_id', 'id');
    }
}
