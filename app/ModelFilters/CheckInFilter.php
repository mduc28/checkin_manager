<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class CheckInFilter extends ModelFilter
{
    /**
     * Filter name of member who checked in
     *
     * @param $value
     * @return mixed
     */
    public function date($value)
    {
        return $this->whereDate('created_at', $value);
    }

    /**
     * Filter type of members who checked in
     *
     * @param $value
     * @return CheckInFilter
     */
    public function type($value)
    {
        return $this->related('members', 'is_member', $value);
    }
}