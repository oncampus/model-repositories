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

    protected $path;

    public function path()
    {
        if(is_null($this->path)) {
            $path = $this->entity_type.'\\'.$this->entity_id.'\\';
            $path = strtolower($path);
            $path = str_replace('app\\', '', $path);
            $this->path = $path;
        }

        return $this->path;
    }

    public function put($fileName, $content)
    {
        return Storage::put($this->path().$fileName, $content, $this->visible);
    }
}
