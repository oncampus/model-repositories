<?php

namespace bedoke\ModelRepositories\Models;
use bedoke\ModelRepositories\Models\Repository;

class PrivateRepository extends Repository
{
    protected $table = 'private_repositories';
    protected $guarded = [];

    /**
     * Overwrites the visibility of
     * the parent class (Repository).
     *
     * @var string
     */
    public $visible = 'private';

}
