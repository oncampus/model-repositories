<?php

namespace Oncampus\ModelRepositories\Traits;


trait PrivateRepository {

    public function privateRepository()
    {
        return $this->morphOne('Oncampus\ModelRepositories\Models\PrivateRepository', 'entity');
    }

}
