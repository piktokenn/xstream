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

require dirname(__DIR__) . '/vendor/autoload.php';

use Cache\Cache;
use Cache\Psr16\Cache as Psr16Cache;

$key = 'an_example_key';

// Create cache object.
$cache = new Cache(__DIR__ .  '/cache');

// Set something to the cache.
$value = 'some string value';
echo 'value set to the cache is ' . $value;
echo PHP_EOL;
$cache->set($key, $value);

// Get something from the cache.
$value = $cache->get($key);
echo 'value got from the cache is ' . $value;
echo PHP_EOL;

// Check if something is expired in cache.
$expired = $cache->exp($key, strtotime('+1 Minute'));
echo $expired ? 'expired' : 'not expired';
echo PHP_EOL;

// Check if something is present in the cache.
$present = $cache->has($key);
echo $present ? 'present' : 'not present';
echo PHP_EOL;

// Delete something from the cache.
$cache->del($key);
echo 'deleted';
echo PHP_EOL;

// Check if something is present in the cache. This time after deleting it.
$present = $cache->has($key);
echo $present ? 'still present' : 'no more present';
echo PHP_EOL;

// Caching an object.
echo PHP_EOL;

/**
 * Class Something
 */
class Something {

    /**
     * @var mixed|null
     */
    public $var1 = null;

    /**
     * @var mixed|null
     */
    public $var2 = null;

    /**
     * This is optional.
     *
     * @param array $an_array
     * @return Something
     */
    public static function __set_state($an_array)
    {
        $obj = new static();
        $obj->var1 = $an_array['var1'];
        $obj->var2 = $an_array['var2'];
        return $obj;
    }
}

// Set something to the cache.
$obj = new Something();
$obj->var1 = 1;
$obj->var2 = $value;
echo 'value set to the cache is ' . print_r($obj, true);
echo PHP_EOL;
$cache->set($key, $obj);

// Get something from the cache.
$obj = $cache->get($key);
echo 'value got from the cache is ' . print_r($obj, true);
echo PHP_EOL;

// Check if something is present in the cache.
$present = $cache->has($key);
echo $present ? 'present' : 'not present';
echo PHP_EOL;

// Clear the whole cache.
$cache->clr();
echo 'cleared';
echo PHP_EOL;

// Check if something is present in the cache. This time after clearing the whole cache..
$present = $cache->has($key);
echo $present ? 'still present' : 'no more present';
echo PHP_EOL;

// The PSR-16 compliant adapter can also be used. It takes a cache instance as constructor argument.
$psrCache = new Psr16Cache($cache);
// Set the cache expiry time to one minute.
$psrCache->setCacheExpiryTime(strtotime('+1 Minute', 0));

// Now the object can be used using the standard interface methods.
echo PHP_EOL;

// The PSR-16 compliant cache also supports sanitizing keys before using them.
// It is generally advised to use the adapter class.
