<?php

namespace bedoke\ModelRepositories\Traits;


trait PrivateRepository {

    public function privateRepository()
    {
        return $this->morphOne('bedoke\ModelRepositories\Models\PrivateRepository', 'entity');
    }

}
