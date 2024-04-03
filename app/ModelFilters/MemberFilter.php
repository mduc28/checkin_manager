<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class MemberFilter extends ModelFilter
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

    public function code($value)
    {
        return $this->whereLike('code', $value);
    }
}