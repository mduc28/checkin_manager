<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class UserFilter extends ModelFilter
{
    /**
     * Filter name of products
     *
     * @param $value
     * @return mixed
     */
    public function name($value)
    {
        return $this->whereLike('name', $value);
    }

    public function role($value)
    {
        return $this->where('role_id', $value);
    }
}