<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'members';

    protected $fillable = [
        'code',
        'name',
        'email',
        'phone',
        'address',
        'birthday',
        'gender',
        'expired_date',
        'is_member',
    ];

    /**
     * Get all of the checkins for the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function checkins()
    {
        return $this->hasMany(CheckIn::class, 'member_id', 'id');
    }
}
