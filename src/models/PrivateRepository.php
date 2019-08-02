<?php

namespace Oncampus\ModelRepositories\Models;
use Oncampus\ModelRepositories\Models\Repository;

class PrivateRepository extends Repository
{
    protected $table = 'private_repositories';
    public $visibility = 'private';

    /**
     * Relation to the connected entity.
     *
     * @return void
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
