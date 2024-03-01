<?php
/**
 * Client Contract
 *
 * @package OrcidDataBlock\Client
 */

namespace MESH\OrcidDataBlock\Contracts;

interface ClientContract {
    /**
     * Retrieves data for a given ORCID.
     *
     * @param string $orcid The ORCID identifier.
     * @param bool   $force (optional) Whether to force a fresh retrieval of the data.
     * @return string|false The retrieved XML data.
     */
    public function get( string $orcid, bool $force = false ): string|false;


    /**
     * Retrieves user data based on the provided user ID.
     *
     * @param int|string $user_id The ID of the user to retrieve data for.
     * @param bool       $force (optional) Whether to force the retrieval of user data even if it is already cached.
     * @return string|false The XML user data.
     */
    public function get_user( int|string $user_id, bool $force = false ): string|false;


    /**
     * Retrieves the current user's ORCID data.
     *
     * @param bool $force Whether to force the retrieval of the current user.
     * @return string|bool The current user.
     */
    public function get_current_user( bool $force = false ): string|false;
}
