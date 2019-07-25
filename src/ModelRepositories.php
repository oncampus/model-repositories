<?php
namespace bedoke\ModelRepositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use bedoke\ModelRepositories\Models\Repository;
use bedoke\ModelRepositories\Models\PrivateRepository;
use bedoke\ModelRepositories\Models\PublicRepository;

class ModelRepositories
{
    /**
     * Creates a repository entry in the database
     * if the entry does not already exist.
     *
     * @param Object $entity
     * @param String $visibility
     * @return boolean
     */
    public function createIfNotExists(Object $entity, String $visibility) : bool
    {
        if($visibility !== 'private' && $visibility !== 'public') {
            return false;
        }

        if($visibility === 'private') {

            $repository = PrivateRepository::where([
                'entity_type' => get_class($entity),
                'entity_id' => $entity->id
            ])->first();

        } else if($visibility === 'public') {

            $repository = PublicRepository::where([
                'entity_type' => get_class($entity),
                'entity_id' => $entity->id
            ])->first();

        }

        if($repository) {
            return true;
        }

        if($visibility === 'private') {
            return $this->createPrivateRepository($entity);
        } else if($visibility === 'public') {
            return $this->createPublicRepository($entity);
        }

        return false;

    }

    /**
     * Creates a public repository.
     *
     * @param Object $entity
     * @return boolean
     */
    private function createPublicRepository(Object $entity) : bool
    {
        $publicRepo = new PublicRepository();
        $publicRepo->entity_type = get_class($entity);
        $publicRepo->entity_id = $entity->id;

        $path = $publicRepo->visibility.'\\'.$publicRepo->entity_type.'\\'.$publicRepo->entity_id.'\\';
        $path = strtolower($path);
        $path = str_replace('app\\', '', $path);

        $publicRepo->path = $path;

        return $publicRepo->save();
    }

    /**
     * Creates a private repository.
     *
     * @param Object $entity
     * @return boolean
     */
    private function createPrivateRepository(Object $entity) : bool
    {
        $privateRepo = new PrivateRepository();
        $privateRepo->entity_type = get_class($entity);
        $privateRepo->entity_id = $entity->id;

        $path = $privateRepo->visibility.'\\'.$privateRepo->entity_type.'\\'.$privateRepo->entity_id.'\\';
        $path = strtolower($path);
        $path = str_replace('app\\', '', $path);

        $privateRepo->path = $path;

        return $privateRepo->save();
    }

    /**
     * Builds the repository path for an entity.
     *
     * @param String $entityType
     * @param Int $entityId
     * @param String $visibility
     * @return String
     */
    public function buildPath(String $entityType, int $entityId, String $visibility) : String
    {
        $path = $visibility.'\\'.$entityType.'\\'.$entityId.'\\';
        $path = strtolower($path);
        $path = str_replace('app\\', '', $path);
        return $path;
    }

}
