<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckIn extends Model
{
    use HasFactory, Filterable, SoftDeletes;

    protected $table = 'checkins';

    protected $fillable = [
        'member_id',
        'is_member',
    ];

    /**
     * Get the member for the Check in
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function members()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id')->withTrashed();
    }
}
