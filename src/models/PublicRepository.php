<?php

namespace Oncampus\ModelRepositories\Models;
use Oncampus\ModelRepositories\Models\Repository;

class PublicRepository extends Repository
{
    protected $table = 'public_repositories';
    public $visibility = 'public';

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
