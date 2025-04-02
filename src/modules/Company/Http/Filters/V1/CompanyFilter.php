<?php

namespace Modules\Company\Http\Filters\V1;

use App\Http\Filters\V1\QueryFilter;

class CompanyFilter extends QueryFilter
{

    protected array $sortable = [
        'name',
        'slug',
        'location',
        'user_id',
        'created_at',
        'updated_at'
    ];

    public function name($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('name', 'like', $likeStr);
    }

    public function slug($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('slug', 'like', $likeStr);
    }

    public function location($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('location', 'like', $likeStr);
    }

    public function user_id($value)
    {
        $likeStr = str_replace('*', '%', $value);
        return $this->builder->where('user_id', 'like', $likeStr);
    }

    public function created_at($value): \Illuminate\Database\Eloquent\Builder
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('created_at', $dates);
        }

        return $this->builder->whereDate('created_at', $value);
    }

    public function updated_at($value): \Illuminate\Database\Eloquent\Builder
    {
        $dates = explode(',', $value);

        if (count($dates) > 1) {
            return $this->builder->whereBetween('updated_at', $dates);
        }

        return $this->builder->whereDate('updated_at', $value);
    }

}
