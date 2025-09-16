<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'subcategories';

    protected $fillable = [
        'association_id',
        'category_id',
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
            'category_id' => 'integer',
            'name' => 'string'
        ];
    }

    public static $rules = [
        'association_id' => 'required|integer|min:1|exists:associations,id',
        'category_id' => 'required|integer|min:1|exists:categories,id',
        'name' => 'required|string|max:255'
    ];

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function scoringRules()
    {
        return $this->hasMany(ScoringRule::class, 'subcategory_id', 'id');
    }
}
