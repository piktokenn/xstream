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

namespace Help;

use Closure;

/**
 * Class Directory
 *
 * @package Help
 */
final class Directory
{
    /**
     * List content of a directory naively.
     *
     * @param string $path
     * @return array|string[]
     */
    public static function list(string $path): array
    {
        $content = [];
        $handle = @opendir($path);

        if ($handle !== false) {
            while (($entry = readdir($handle)) !== false) {
                $content[] = $entry;
            }

            closedir($handle);
        }

        return $content;
    }

    /**
     * List content of a directory naively. Filter entries not matching a given pattern.
     *
     * @param string $path
     * @param string $pattern
     * @return array|string[]
     */
    public static function listPattern(string $path, string $pattern = ''): array
    {
        $content = static::list($path);

        if (empty($content) || empty($pattern)) {
            return $content;
        }

        return array_filter($content, function (string $entry) use ($pattern): bool {
            return (bool)preg_match($pattern, $entry);
        });
    }

    /**
     * List content of a directory naively. Filter entries returning a non-falsy value from the callback.
     *
     * @param string $path
     * @param Closure|null $callback
     * @return array|string[]
     */
    public static function listCallback(string $path, ?Closure $callback = null): array
    {
        $content = static::list($path);

        if (empty($content) || null === $callback) {
            return $content;
        }

        return array_filter($content, $callback);
    }
}
