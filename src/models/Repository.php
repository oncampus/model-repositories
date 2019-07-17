<?php

namespace bedoke\ModelRepositories\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Repository extends Model
{
    /**
     * This variable tells whether the current
     * repository class is public or private.
     * It can be overwritten in extended classes.
     *
     * @var string
     */
    public $visible = 'public';

    public function path()
    {
        return $this->entity_type.'\\'.$this->entity_id.'\\';
    }

    public function put($file)
    {
        return Storage::put($file, $this->path(), $this->visible);
    }
}
