<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'association_id',
        'label',
        'required_score',
        'expirated_at'
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
            'label' => 'string',
            'required_score' => 'integer',
            'expirated_at' => 'timestamp'
        ];
    }

    public static $rules = [
        'association_id' => 'required|integer|min:1|exists:associations,id',
        'label' => 'required|string|max:191',
        'required_score' => 'required|integer',
        'expirated_at' => 'nullable|date_format:Y-m-d H:i:s'
    ];

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('score_at_award')->withTimestamps();
    }
}
