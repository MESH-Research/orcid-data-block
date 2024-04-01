<?php
/**
 * Admin settings controller
 *
 * @package OrcidDataBlock
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Controller;

use MESH\OrcidDataBlock\Contracts\ClientContract;

/**
 * Admin controller
 */
class AdminController extends Controller {
    /**
     * Client
     *
     * @var ClientContract
     */
    private $client;

    /**
     * Constructor
     *
     * @param ClientContract $client Client.
     */
    public function __construct( ClientContract $client ) {
        $this->client = $client;
    }

    /**
     * Settings menu
     *
     * @return mixed
     */
    public function settings_page(): mixed {
        $user_ob = wp_get_current_user();
        $user    = $user_ob->ID;
        $this->set('orcid_id', '');

        if (! empty(get_user_meta($user, '_orcid_id', true))) {
            $orcid_id = get_user_meta($user, '_orcid_id', true);
            $this->set('orcid_id', $orcid_id);
            $this->set('orcid_data', $this->client->get($orcid_id));
        }

        if (isset($_POST['submit'])) {
            // +++++++++++++++++++++++++++++++++++++++++++++++++++++
            // check_admin_referer('orcid_nonce')?
            // this used for security to validate form data came from current site.
            // see: https://codex.wordpress.org/Function_Reference/check_admin_referer
            // nonce: https://wordpress.org/support/article/glossary/#nonce
            // +++++++++++++++++++++++++++++++++++++++++++++++++++++
            check_admin_referer('orcid_nonce');

            if (isset($_POST['orcid_id'])) {
                $new_id = $_POST['orcid_id'];
                if (!preg_match('/^\d{4}-\d{4}-\d{4}-\d{3}[\dX]$/', $new_id)) {
                    $this->set('orcid_error', __('The ORCID does not seem to be a valid format.', 'orcid-data-block'));
                    return null;
                }
                // Fetch the orcid data to confirm that the orcid id is valid.
                $data = $this->client->get($new_id, true);
                if (false === $data) {
                    $this->set('orcid_error', __('The ORCID supplied does not exist.', 'orcid-data-block'));
                    return null;
                }
                update_user_meta($user, '_orcid_id', $new_id);

                $this->set('orcid_id', $new_id);
                $this->set('orcid_data', $data);
                $this->set('success', true);

            }
        }
        return null;
    }
}
