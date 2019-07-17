<?php

namespace bedoke\ModelRepositories\Traits;


trait PublicRepository {

    public function publicRepository()
    {
        return $this->morphOne('bedoke\ModelRepositories\Models\PublicRepository', 'entity');
    }

}
