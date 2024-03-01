<?php
/**
 * BaseFormatter
 *
 * @package OrcidDataBlock\Formatter
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Formatter;

/**
 * BaseFormatter
 */
class BaseFormatter {
    /**
     * The default options.
     *
     * @var array
     */
    protected $default_options = array(
        'display_header'             => false,
        'display_personal'           => false,
        'display_education'          => false,
        'display_employment'         => false,
        'display_works'              => false,
        'works_type'                 => 'all',
        'works_start_year'           => '1900',
        'display_fundings'           => false,
        'display_peer_reviews'       => false,
        'display_invited_positions'  => false,
        'display_memberships'        => false,
        'display_qualifications'     => false,
        'display_research_resources' => false,
        'display_services'           => false,
    );

    /**
     * The options to be passed to the XSLTProcessor.
     *
     * @var array
     */
    protected $options;

    /**
     * Set the options to be passed to the XSLTProcessor.
     *
     * @param array $options The options to be passed to the XSLTProcessor.
     * @return void
     */
    public function set_options( array $options ): void {
        $this->options = array_merge($this->default_options, $options);
    }

    /**
     * Set a single option.
     *
     * @param string $key The option key.
     * @param mixed  $value The option value.
     * @return void
     */
    public function set_option( string $key, mixed $value ): void {
        $this->options[ $key ] = $value;
    }

    /**
     * BaseFormatter constructor.
     */
    public function __construct() {
        $this->options = $this->default_options;
    }
}
