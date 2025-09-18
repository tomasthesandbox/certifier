<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'alternate_email',
        'role_id',
        'organization_id',
        'association_id',
        'position'
    ];

    protected $hidden = [
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'lastname' => 'string',
            'email' => 'string',
            'alternate_email' => 'string',
            'role_id' => 'integer',
            'organization_id' => 'integer',
            'association_id' => 'integer',
            'position' => 'string'
        ];
    }

    public static $rules = [
        'name' => 'required|string|max:191',
        'lastname' => 'required|string|max:191',
        'email' => 'required|string|max:191',
        'alternate_email' => 'nullable|string|max:191',
        'role_id' => 'required|integer|min:1|exists:roles,id',
        'organization_id' => 'required|integer|min:1|exists:organizations,id',
        'association_id' => 'required|integer|min:1|exists:associations,id',
        'position' => 'required|string|max:191'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id', 'id');
    }

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id', 'id');
    }

    public function certificates()
    {
        return $this->belongsToMany(Certificate::class)->withPivot('score_at_award')->withTimestamps();
    }

    public function scoringRules()
    {
        return $this->belongsToMany(ScoringRule::class)->withPivot([
            'activity_name',
            'points_int',
            'date_of_completion',
            'document_file',
            'document_text'
        ])->withTimestamps();
    }

    public function hits()
    {
        return $this->hasMany(Hit::class, 'user_id', 'id');
    }

    public function accessLogs()
    {
        return $this->hasMany(AccessLog::class, 'user_id', 'id');
    }
}
