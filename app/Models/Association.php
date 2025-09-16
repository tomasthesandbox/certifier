<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Association extends Model
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
        return $this->hasMany(User::class, 'association_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'association_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'association_id', 'id');
    }

    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'association_id', 'id');
    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'association_id', 'id');
    }

    public function sources()
    {
        return $this->hasMany(Source::class, 'association_id', 'id');
    }

    public function durations()
    {
        return $this->hasMany(Duration::class, 'association_id', 'id');
    }

    public function scoringRules()
    {
        return $this->hasMany(ScoringRule::class, 'association_id', 'id');
    }
}
