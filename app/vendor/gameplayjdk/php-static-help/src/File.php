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

/**
 * Class File
 *
 * @package Help
 */
final class File
{
    /**
     * Read a file naively. Chunk size is 1024.
     *
     * @param string $path
     * @return string
     */
    public static function read(string $path): string
    {
        $content = '';

        if (is_readable($path)) {
            $handle = @fopen($path, 'r');

            if (false !== $handle) {
                while (!feof($handle) && false !== ($chunk = fread($handle, 1024))) {
                    $content .= $chunk;
                }

                fclose($handle);
            }
        }

        return $content;
    }

    /**
     * Write a file naively. Chunk size is 1024.
     *
     * @param string $path
     * @param string $content
     */
    public static function write(string $path, string $content): void
    {
        if (!file_exists($path) || (file_exists($path) && is_writable($path))) {
            $handle = @fopen($path, 'w');

            if (false !== $handle) {
                while (0 < strlen($content) && false !== ($chunk = fwrite($handle, $content, 1024))) {
                    $content = substr($content, $chunk) ?: '';
                }

                fclose($handle);
            }
        }
    }
}
