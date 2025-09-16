<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoringRule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'association_id',
        'category_id',
        'subcategory_id',
        'activity_id',
        'source_id',
        'duration_id',
        'points'
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
            'subcategory_id' => 'integer',
            'activity_id' => 'integer',
            'source_id' => 'integer',
            'duration_id' => 'integer',
            'points' => 'integer'
        ];
    }

    public static $rules = [
        'association_id' => 'required|integer|min:1|exists:associations,id',
        'category_id' => 'required|integer|min:1|exists:categories,id',
        'subcategory_id' => 'required|integer|min:1|exists:subcategories,id',
        'activity_id' => 'required|integer|min:1|exists:activities,id',
        'source_id' => 'required|integer|min:1|exists:sources,id',
        'duration_id' => 'required|integer|min:1|exists:durations,id',
        'points' => 'required|integer'
    ];

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id', 'id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id', 'id');
    }

    public function duration()
    {
        return $this->belongsTo(Duration::class, 'duration_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot([
            'activity_name',
            'points_int',
            'date_of_completion',
            'document_file',
            'document_text'
        ])->withTimestamps();
    }
}
