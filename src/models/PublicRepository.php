<?php

namespace bedoke\ModelRepositories\Models;
use bedoke\ModelRepositories\Models\Repository;

class PublicRepository extends Repository
{
    protected $table = 'public_repositories';
    protected $guarded = [];

    public function entity()
    {
        return $this->morphTo();
    }
}
