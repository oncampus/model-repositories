<?php

namespace bedoke\ModelRepositories\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use bedoke\ModelRepositories\Facades\ModelRepositories;

class Repository extends Model
{
    protected $fillable = [
        'entity_type',
        'entity_id',
        'path'
    ];

    public function path()
    {
        if(is_null($this->path)) {
            $this->path = ModelRepositories::buildPath(
                $this->entity_type,
                $this->entity_id,
                $this->visibility
            );
            $this->save();
        }

        return $this->path;
    }

    public function put($fileName, $content, $driver = 'local')
    {
        return Storage::disk($driver)
            ->put($this->path().$fileName, $content, $this->visibility);
    }

}
