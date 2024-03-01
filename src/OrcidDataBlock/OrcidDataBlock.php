<?php
/**
 * OrcidDataBlock Main Class
 *
 * @package OrcidDataBlock
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock;

use MESH\OrcidDataBlock\Contracts\ClientContract;
use MESH\OrcidDataBlock\Contracts\FormatterContract;
use MESH\OrcidDataBlock\Controller\AdminController;

/**
 * Main class for the plugin
 */
class OrcidDataBlock {
    /**
     * Instance
     *
     * @var OrcidDataBlock
     */
    private static $instance;

    /**
     * Client
     *
     * @var ClientContract $client The client object used for interacting with the ORCID API.
     */
    private $client;

    /**
     * Formatter
     *
     * @var FormatterContract $formatter The formatter object used for converting XML to HTML.
     */
    private $formatter;



    /**
     * Instantiate a singleton instance of the plugin.
     *
     * @param ClientContract    $client The client object used for interacting with the ORCID API.
     * @param FormatterContract $formatter The formatter object used for converting XML to HTML.
     *
     * @return OrcidDataBlock
     */
    public static function boot( ClientContract $client, FormatterContract $formatter ): OrcidDataBlock {
        if (null === self::$instance) {
            self::$instance = new static($client, $formatter);
        }
        return self::$instance;
    }

    /**
     * Plugin constructor
     *
     * @param ClientContract    $client The client object used for interacting with the ORCID API.
     * @param FormatterContract $formatter The formatter object used for converting XML to HTML.
     *
     * @return void
     */
    private function __construct( ClientContract $client, FormatterContract $formatter ) {
        $this->client    = $client;
        $this->formatter = $formatter;
        add_action('init', array( $this, 'init' ));
        add_action('admin_menu', array( $this, 'register_admin_menu' ));
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init(): void {
        $this->register_block();
        $this->register_shortcodes();
    }

    /**
     * Register the block
     *
     * @return void
     */
    public function register_block(): void {
        register_block_type(
            ORCID_DATA_BLOCK_DIR . DIRECTORY_SEPARATOR . 'build',
            array(
                'api_version' => 2,
                'render_callback' => array( $this, 'render_block' ),
            )
        );
    }

    /**
     * Register the shortcode
     *
     * @return void
     */
    public function register_shortcodes(): void {
        add_shortcode('orcid-data', array( $this, 'render_shortcode' ));
    }

    /**
     * Register the admin menu
     *
     * @return void
     */
    public function register_admin_menu(): void {
        add_menu_page(
            'My ORCiD Retrieval and Display Information',
            'My ORCiD Profile',
            'edit_posts',
            'orcid_data_block_settings',
            array( $this, 'admin_settings_form' )
        );
    }

    /**
     * Render the block
     *
     * @param array  $block_attributes Attributes.
     * @param string $content Content.
     *
     * @return string
     */
    public function render_block( array $block_attributes, string $content ): string {

        $section          = $block_attributes['section'];
        $works_start_year = $block_attributes['worksStartYear'];
        $works_type       = $block_attributes['worksType'];


        $section = strtolower($section);

        $author = get_the_author_meta('ID', false);

        $data = $this->client->get_user($author);

        $options[ "display_{$section}" ] = true;
        $options['works_type']           = $works_type;
        $options['works_start_year']     = $works_start_year;

        return $this->formatter->to_html($data['xml'], $options);
    }

    /**
     * Render the shortcode
     *
     * @param array  $atts Attributes.
     * @param string $content Content.
     * @param string $tag Tag.
     *
     * @return string
     */
    public function render_shortcode( array $atts = array(), string $content = null, string $tag = '' ): string {

        // normalize attribute keys to lowercase.
        $atts = array_change_key_case(
            (array) $atts,
            CASE_LOWER
        );

        $atts =            shortcode_atts(
            array(
                'section'          => 'header',
                'works_type'       => 'all',
                'works_start_year' => '1900',
            ),
            $atts
        );

        // Get the author's WordPress user id.
        $author  = get_the_author_meta('ID', false);
        $section = $atts['section'];

        $data = $this->client->get_user($author);

        $options = array(
            "display_{$section}" => true,
            'works_type'         => $atts['works_type'],
            'works_start_year'   => $atts['works_start_year'],
        );

        $this->formatter->set_options($options);

        return $this->formatter->to_html($data['xml']);
    }

    /**
     * Render the settings form for the users Orcid ID
     */
    public function admin_settings_form(): void {
        AdminController::startup($this->client)
            ->handle('settings_page');
    }

    /**
     * Activates the OrcidDataBlock plugin.
     */
    public function activate(): void {
        // TODO: Make cache time configurable in plugin settings.
    }

    /**
     * Deactivates the OrcidDataBlock plugin
     */
    public function deactivate(): void {
        // TODO: Remove cache time configuration in plugin settings.
    }
}
