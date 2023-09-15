<?php
/**
 * The MIT License (MIT)
 * Copyright (c) 2020 GameplayJDK
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

namespace Cache;

use Brick\VarExporter\VarExporter;
use Cache\Exception\CacheException;
use Exception;
use Help\Directory;
use Help\Path;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Class Cache
 *
 * @package Cache
 */
class Cache
{
    const FILE_EXTENSION = '.php';
    const FILE_PATTERN = '/^.+\.php$/';

    /**
     * @var string
     */
    private $path;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Cache constructor.
     *
     * @param string $path
     * @param Filesystem $filesystem
     */
    public function __construct(string $path, ?Filesystem $filesystem = null)
    {
        $this->path = $path;
        $this->filesystem = $filesystem ?: (new Filesystem());
        // TODO: Check if the mode used here is correct.
        $this->filesystem->mkdir($this->path);
    }

    /**
     * Get a cache file value. If there is no value, null is returned.
     *
     * @param string $key
     * @return mixed
     * @throws CacheException
     */
    public function get(string $key)
    {
        $path = $this->getPath($key);

        if ($this->filesystem->exists($path)) {
            @include $path;

            if (isset($value)) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Set a value for a cache file. The value can be anything.
     *
     * @param string $key
     * @param mixed $value
     * @throws CacheException
     */
    public function set(string $key, $value): void
    {
        $path = $this->getPath($key);

        try {
            $valueExport = VarExporter::export($value);
            $valueExport = '<?php $value = ' . $valueExport . ';';

            $this->filesystem->dumpFile($path, $valueExport);
        } catch (Exception $exception) {
            throw new CacheException('Unsupported operation: The value could not be exported properly.', 0, $exception);
        }
    }

    /**
     * Check whether a cache file exists.
     *
     * @param string $key
     * @return bool
     * @throws CacheException
     */
    public function has(string $key): bool
    {
        $path = $this->getPath($key);

        return $this->filesystem->exists($path);
    }

    /**
     * Delete a cache file, if it exists.
     *
     * @param string $key
     * @throws CacheException
     * @throws IOException
     */
    public function del(string $key): void
    {
        $path = $this->getPath($key);

        $this->filesystem->remove($path);
    }

    /**
     * Check whether a cache file has expired, e.g. is older than given `$time`, which represents a timestamp. If the
     * file does not exist, the cache file counts as expired. The cache file expiration time is measured using the
     * {@link filectime()} function.
     *
     * @param string $key
     * @param int $time
     * @return bool
     * @throws CacheException
     */
    public function exp(string $key, int $time): bool
    {
        $path = $this->getPath($key);

        if ($this->filesystem->exists($path)) {
            return filectime($path) < $time;
        }

        return true;
    }

    /**
     * Clear all cache files. The {@link Directory::listPattern()} utility function is used to determine all cache files
     * that match the cache file extension pattern.
     *
     * @throws CacheException
     */
    public function clr(): void
    {
        $list = Directory::listPattern($this->path, static::FILE_PATTERN);

        foreach ($list as $entry) {
            $this->filesystem->remove($this->getPath($entry));
        }
    }

    /**
     * Get the full path of a cache file by its name. The {@link Path::join()} utility function is used to combine the
     * file name and the path of this cache.
     *
     * @param string $file
     * @return string
     * @throws CacheException
     */
    protected function getPath(string $file): string
    {
        if (empty($file)) {
            throw new CacheException('Unsupported operation: An empty file name is not allowed.');
        }

        $file = $this->getFile($file, static::FILE_EXTENSION);

        return Path::join(...[
            $this->path,
            $file,
        ]);
    }

    /**
     * Get the filename with the given extension, if it is not already present in the filename.
     *
     * @param string $file
     * @param string $extension
     * @return string
     */
    protected function getFile(string $file, string $extension): string
    {
        return (strrpos($file, $extension) === (strlen($file) - strlen($extension)))
            ? $file
            : $file . $extension;
    }
}
