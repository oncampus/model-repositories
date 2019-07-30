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
            $disk = config('filesystems.default');
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
        $this->disk = config('filesystems.default');
    }

    /**
     * Write the contents of a file.
     * The visibility attribute in options will be set to
     * public or private. It dependes on the repository Object
     * (publicRepository = 'public', privateRepository = 'private').
     *
     * @param  string  $filePpath
     * @param  string|resource  $contents
     * @param  mixed  $options
     * @return bool
     */
    public function put($path, $contents, Array $options = [])
    {
        $options['visibility'] = $this->visibility;

        $path = $this->preparePath($path);

        $return =  Storage::disk($this->disk)
            ->put($path, $contents, $options);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Store the uploaded file on the disk with a given name.
     * The visibility attribute in options will be set to
     * public or private. It dependes on the repository Object
     * (publicRepository = 'public', privateRepository = 'private').
     *
     * @param  string  $path
     * @param  \Illuminate\Http\File|\Illuminate\Http\UploadedFile  $file
     * @param  string  $name
     * @param  array  $options
     * @return string|false
     */
    public function putFileAs($path, $file, $name, $options = [])
    {
        $options['visibility'] = $this->visibility;

        $path = $this->preparePath($path);

        $return =  Storage::disk($this->disk)
            ->putFileAs($path, $file, $name, $options);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Store the uploaded file on the disk.
     * The visibility attribute in options will be set to
     * public or private. It dependes on the repository Object
     * (publicRepository = 'public', privateRepository = 'private').
     *
     * @param  string  $path
     * @param  \Illuminate\Http\File|\Illuminate\Http\UploadedFile  $file
     * @param  array  $options
     * @return string|false
     */
    public function putFile($path, $file, $options = [])
    {
        $options['visibility'] = $this->visibility;

        $path = $this->preparePath($path);

        $return = $this->putFileAs(
            $path, $file, $file->hashName(), $options
        );

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

        $return = Storage::disk($this->disk)
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

        $return = Storage::disk($this->disk)
            ->url($filePath);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * For files stored using the s3 or rackspace driver,
     * you may create a temporary URL to a given file using the temporaryUrl method.
     * This methods accepts a path and a DateTime instance specifying when the URL should expire.
     *
     * @param [type] $filePath
     * @param  \DateTimeInterface  $expiration
     * @param  Array  $options
     * @return String
     *
     * @throws \RuntimeException
     */
    public function temporaryUrl($filePath, $expiration, array $options = []) : String
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->disk)
            ->temporaryUrl($filePath, $expiration, $options);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Returns the size of the file in bytes.
     *
     * @param [type] $filePath
     * @return integer
     *
     * @throws FileNotFoundException
     */
    public function size($filePath) : int
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->disk)
            ->size($filePath);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get the file's last modification time.
     * Returns an unix timestamp.
     *
     * @param  string  $path
     * @return int
     *
     * @throws FileNotFoundException
     */
    public function lastModified($filePath) : int
    {
        $filePath = $this->preparePath($filePath);

        $return = Storage::disk($this->disk)
            ->lastModified($filePath);

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

    /**
     * Get all (recursive) of the directories within a given directory.
     *
     * @param  string|null  $directory
     * @return array
     */
    public function allDirectories($directory = null)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->allDirectories($directory);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get all of the directories within a given directory.
     *
     * @param  string|null  $directory
     * @param  bool  $recursive
     * @return array
     */
    public function directories($directory = null, $recursive = false)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->directories($directory, $recursive);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get all of the files from the given directory (recursive).
     *
     * @param  string|null  $directory
     * @return array
     */
    public function allFiles($directory = null)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->allFiles($directory);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Append to a file.
     *
     * @param  string  $path
     * @param  string  $data
     * @param  string  $separator
     * @return bool
     */
    public function appendContent($path, $data, $separator = PHP_EOL)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->append($path, $data, $separator);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Prepend to a file.
     *
     * @param  string  $path
     * @param  string  $data
     * @return int
     */
    public function prependContent($path, $data)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->prepend($path, $data);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get the mime-type of a given file.
     *
     * @param  string  $path
     * @return string|false
     */
    public function mimeType($path)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->mimeType($path);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get the file type of a given file.
     *
     * @param  string  $path
     * @return string
     */
    public function type($path)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->type($path);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Determine if the given path is a directory.
     *
     * @param  string  $directory
     * @return bool
     */
    public function isDirectory($directory)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->isDirectory($directory);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Determine if the given path is a file.
     *
     * @param  string  $path
     * @return bool
     */
    public function isFile($path)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->isFile($path);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Determine if the given path is readable.
     *
     * @param  string  $path
     * @return bool
     */
    public function isReadable($path)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->isReadable($path);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Determine if the given path is writable.
     *
     * @param  string  $path
     * @return bool
     */
    public function isWritable($path)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->isWritable($path);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Empty the specified directory of all files and folders.
     *
     * @param  string  $directory
     * @return bool
     */
    public function cleanDirectory($directory)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->cleanDirectory($directory);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get an array of all files in a directory.
     *
     * @param  string|null  $directory
     * @param  bool  $recursive
     * @return array
     */
    public function files($directory = null, $recursive = false)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->files($directory, $recursive);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Create a directory.
     *
     * @param  string  $path
     * @return bool
     */
    public function makeDirectory($path)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->makeDirectory($path);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Recursively delete a directory.
     *
     * @param  string  $directory
     * @return bool
     */
    public function deleteDirectory($directory)
    {
        if(is_null($directory)) {
            $directory = '';
        }

        $directory = $this->preparePath($directory);

        $return = Storage::disk($this->disk)
            ->deleteDirectory($directory);

        $this->setDefaultDisk();

        return $return;
    }

    /**
     * Get or set UNIX mode of a file or directory.
     *
     * @param  string  $path
     * @param  int|null  $mode
     * @return mixed
     */
    public function chmod($path, $mode = null)
    {
        $path = $this->preparePath($path);

        $return = Storage::disk($this->disk)
            ->chmod($path, $mode);

        $this->setDefaultDisk();

        return $return;
    }


}
