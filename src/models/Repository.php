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

    /**
     * The current disk for the Storage.
     */
    private $disk;

    public function __construct()
    {
        $this->setDefaultDisk();
    }

    /**
     * Changes the repository disk and returns the repository object.
     *
     * @param String $disk
     * @return void
     */
    public function disk(String $disk = null) {

        if(is_null($disk)) {
            $disk = config('model_repositories.default_disk');
        }

        $this->disk = $disk;
        return $this;
    }

    /**
     * Sets the default disk to the current disk.
     *
     * @return void
     */
    public function setDefaultDisk()
    {
        $this->disk = config('model_repositories.default_disk');
    }

    /**
     * Calls the Storage put function.
     *
     * @param Array|String $fileName
     * @param String $content
     * @param string $disk
     * @return void
     */
    public function put($filePath, $contents)
    {
        $filePath = $this->preparePath($filePath);

        $return =  Storage::disk($this->disk)
            ->put($filePath, $contents, $this->visibility);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Calls the Storage delete function.
     *
     * @param Array|String $filePath
     * @param string $disk
     * @return void
     */
    public function remove($filePath, $disk = 'local')
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($disk)
            ->delete($filePath);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Checks if a file exists in the repository.
     *
     * @param String $filePath
     * @return boolean
     */
    public function exists($filePath) : bool
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->disk)
            ->exists($filePath);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * The get method may be used to retrieve the contents of a file.
     * The raw string contents of the file will be returned by the method.
     * Returns an FileNotFoundException if the file does not exists!
     *
     * @param String $filePath
     * @return String|boolean
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function get($filePath)
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->disk)
            ->get($filePath);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Undocumented function
     *
     * @param String $filePath
     * @param String|null $newFileName
     * @param Array|null $headers
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     *
     * @throws FileNotFoundException
     */
    public function download($filePath, $newFileName = null, array $headers = [])
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->diks)
            ->download($filePath, $newFileName, $headers);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * If you are using the local driver, this will typically just
     * prepend /storage to the given path and return a relative URL to the file.
     * If you are using the s3 or rackspace driver,
     * the fully qualified remote URL will be returned:
     *
     * @param String $filePath
     * @return String
     *
     * @throws FileNotFoundException
     */
    public function url($filePath) : String
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->diks)
            ->url($filePath);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Prepares the filePath and changes it to
     * the real repository file path.
     *
     * @param Array|String $filePath
     * @return void
     */
    public function preparePath($filePath)
    {
        if(is_array($filePath)) {
            for($i = 0; $i < count($filePath); $i++) {
                $filePath[$i] = $this->path . $filePath[$i];
            }
        } else {
            $filePath = $this->path . $filePath;
        }

        return $filePath;
    }

}
