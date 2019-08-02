<?php

namespace Oncampus\ModelRepositories\Traits;


trait PublicRepository {

    public function publicRepository()
    {
        return $this->morphOne('Oncampus\ModelRepositories\Models\PublicRepository', 'entity');
    }

}
