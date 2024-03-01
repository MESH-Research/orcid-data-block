<?php
/**
 * Orcid Client with caching
 *
 * @package OrcidDataBlock\Client
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Client;

use MESH\OrcidDataBlock\Contracts\ClientContract;
use MESH\OrcidDataBlock\Contracts\CacheContract;

/**
 * Orcid Client
 */
class OrcidClient implements ClientContract {
    /**
     * Cache
     *
     * @var CacheContract
     */
    private $cache;

    /**
     * Default transient prefix
     *
     * @var string
     */
    private $transient_prefix = 'orcid_data_block';

    /**
     * Constructor
     *
     * @param CacheContract $cache Cache.
     */
    public function __construct( CacheContract $cache ) {
        $this->cache = $cache;
    }

    /**
     * Get the orcid data
     *
     * @param string  $orcid Orcid.
     * @param boolean $force Bust the cache.
     * @return array|false
     */
    public function get( string $orcid, bool $force = false ): array|false {
        if (!$force) {
            $cached = $this->cache->get($this->get_transient_key($orcid));
            if ($cached) {
              // If the cached value is a string, it's the XML data.
              if ('string' === gettype($cached)) {
                return array('xml' => $cached, 'fetched' => false);
              }

              return $cached;
            }
        }

        $data = [];

        $data['xml'] = $this->fetch($orcid);

        if (false === $data['xml']) {
            return false;
        }
        $data['fetched'] = time();
        $this->cache->save($this->get_transient_key($orcid), $data);

        return $data;
    }

    /**
     * Fetch the orcid data
     *
     * @param string $orcid Orcid.
     * @return string|false
     */
    protected function fetch( string $orcid ): string|false {
        $response = wp_remote_get('https://pub.orcid.org/v3.0/' . $orcid);
        if (is_wp_error($response)) {
            return false;
        }
        if (200 !== $response['response']['code']) {
            return false;
        }
        return $response['body'];
    }

    /**
     * Get the current user's orcid data
     *
     * @param boolean $force Bust the cache.
     * @return array|false
     */
    public function get_current_user( bool $force = false ): array|false {
        $user = wp_get_current_user();

        return $this->get_user($user->ID, $force);
    }

    /**
     * Get a specified user's orcid data
     *
     * @param string|int $user_id User ID.
     * @param boolean    $force Bust the cache.
     * @return array|false
     */
    public function get_user( string|int $user_id, bool $force = false ): array|false {
        $orcid_id = get_user_meta($user_id, '_orcid_id', true);

        return $this->get($orcid_id, $force);
    }

    /**
     * Get the transient key
     *
     * @param string $orcid Orcid.
     * @return string
     */
    public function get_transient_key( string $orcid ): string {
        return $this->transient_prefix . $orcid;
    }
}
