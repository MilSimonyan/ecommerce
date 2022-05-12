<?php

namespace App\Repositories;

use App\Models\Attribute;

class AttributeRepository
{
    public function model(): Attribute
    {
        return new Attribute();
    }

    public function find(string $id): ?Attribute
    {
        return $this->model()->find($id);
    }

    public function findWith(string $id, array $relations = []): ?Attribute
    {
        return $this->model()->with($relations)->find($id);
    }
}
