<?php

namespace bedoke\ModelRepositories\Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use bedoke\ModelRepositories\Facades\ModelRepositories;
use bedoke\ModelRepositories\Models\PublicRepository;

class RepositoryTest extends TestCase
{

    private $fileName = 'testfile.txt';
    private $content = 'test!';
    private $repository;

    /**
     * Tests the $repository->put() function.
     *
     * @return void
     */
    public function testPutFile()
    {
        $this->setFakeRepository();

        $putReturn = $this->repository->put($this->fileName, $this->content);
        $this->assertTrue($putReturn);
    }

    /**
     * Tests the $repository->exists() function.
     *
     * @return void
     */
    public function testFileExists()
    {
        $this->setFakeRepository();

        $this->repository->put($this->fileName, $this->content);
        $existsReturn = $this->repository->exists($this->fileName);
        $this->assertTrue($existsReturn);
    }

    /**
     * Tests the $repository->remove() function.
     *
     * @return void
     */
    public function testDeleteFile()
    {
        $this->setFakeRepository();

        if(!$this->repository->exists($this->fileName)) {
            $this->repository->put($this->fileName, $this->content);
        }

        $removeReturn = $this->repository->remove($this->fileName);
        $this->assertTrue($removeReturn);
    }

    /**
     * Tests the $repository->get() function.
     *
     * @return void
     */
    public function testFileContentAfterPut()
    {
        $this->setFakeRepository();

        if(!$this->repository->exists($this->fileName)) {
            $this->repository->put($this->fileName, $this->content);
        }

        $fileContent = $this->repository->get($this->fileName);
        $this->assertEquals($fileContent, $this->content);
    }

    /**
     * Creates a fake repository which is connected
     * with an fake model entity.
     *
     * @return void
     */
     private function setFakeRepository()
    {
        if(!is_object($this->repository)) {
            $repository = new PublicRepository();
            $repository->entity_type = 'FakeEntity';
            $repository->entity_id = 777;
            $repository->path = ModelRepositories::buildPath(
                $repository->entity_type, $repository->entity_id, $repository->visibility
            );
            $this->repository = $repository;
        }
    }
}
