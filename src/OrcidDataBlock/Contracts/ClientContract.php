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
     * @return string The retrieved XML data.
     */
    public function get( $orcid, $force = false );


    /**
     * Retrieves user data based on the provided user ID.
     *
     * @param int|string $user_id The ID of the user to retrieve data for.
     * @param bool       $force (optional) Whether to force the retrieval of user data even if it is already cached.
     * @return string The XML user data.
     */
    public function get_user( $user_id, $force = false );


    /**
     * Retrieves the current user's ORCID data.
     *
     * @param bool $force Whether to force the retrieval of the current user.
     * @return mixed The current user.
     */
    public function get_current_user( $force = false );
}
