<?php

namespace App\Repositories;

interface AttributeRepositoryInterface
{
    /**
     * @return mixed
     */

    public function model();

    /**
     * @param string $id
     * @return mixed
     */

    public function find(string $id);

    /**
     * @param string $id
     * @param array $relations
     * @return mixed
     */
    public function findWith(string $id, array $relations = []);
}
