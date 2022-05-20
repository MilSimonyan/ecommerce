<?php

namespace App\Repositories;

use App\Models\Rate;

class RateRepository
{
    public function model(): Rate
    {
        return new Rate();
    }

    public function find($id): ?Rate
    {
        return $this->model()->find($id);
    }

    public function where($first, $second)
    {
        return $this->model()->where($first, $second);
    }
}
