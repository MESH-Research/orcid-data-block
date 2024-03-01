<?php
/**
 * Cache contract
 *
 * @package OrcidDataBlock\Cache
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Contracts;

/**
 * Cache contract class
 */

interface CacheContract {
    /**
     * Get a key from cache.
     *
     * @param string $key The key to fetch.
     * @return mixed
     */
    public function get( string $key ): mixed;

    /**
     * Save a value to the cache.
     *
     * @param string $key The key to save.
     * @param mixed  $value The value to save.
     * @return void
     */
    public function save( string $key, mixed $value ): void;
}
