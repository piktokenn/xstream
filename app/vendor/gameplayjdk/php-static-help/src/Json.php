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
 * Class Json
 *
 * @package Help
 */
final class Json
{
    /**
     * Encode an array to a json string naively. That means, the php and json type are assumed.
     *
     * @param array $var
     * @param bool $pretty
     * @return string
     */
    public static function encode(array $var, bool $pretty = false): string
    {
        $result = json_encode($var, ($pretty ? JSON_PRETTY_PRINT : 0));

        if (false === $result || !is_string($result)) {
            $result = '';
        }

        return $result;
    }

    /**
     * Decode a json string to an array naively. That means, the php and json type are assumed.
     *
     * @param string $var
     * @return array
     */
    public static function decode(string $var): array
    {
        $result = json_decode($var, true);

        if (null === $result || !is_array($result)) {
            $result = [];
        }

        return $result;
    }

    /**
     * @return int
     */
    public static function getError(): int
    {
        return json_last_error();
    }

    /**
     * @return string
     */
    public static function getErrorMessage(): string
    {
        return json_last_error_msg() ?: '';
    }
}
