<?php
/**
 * WordPress transient cache
 *
 * @package OrcidDataBlock\Cache
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Cache;

use MESH\OrcidDataBlock\Contracts\CacheContract;

/**
 * WordPress transient cache
 */
class WPTransientCache implements CacheContract {
    /**
     * Cache time in seconds
     *
     * @var integer
     */
    private $expiration = 60 * 60 * 24 * 1; // 1 day


    /**
     * Constructor
     *
     * @param integer $expiration The expiration time in seconds (optional).
     */
    public function __construct( int $expiration ) {
        $this->expiration = $expiration ?? $this->expiration;
    }

    /**
     * Get a key from cache.
     *
     * @param string $key The key to fetch.
     * @return mixed
     */
    public function get( string $key ): mixed {
        return get_transient($key);
    }

    /**
     * Save a value to the cache.
     *
     * @param string $key The key to save.
     * @param mixed  $value The value to save.
     * @return void
     */
    public function save( string $key, mixed $value ): void {
        set_transient($key, $value, 60 * 60 * 24 * 1);
    }
}
