<?php
/**
 * Formatter contract
 *
 * @package OrcidDataBlock\Formatter
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Contracts;

interface FormatterContract {
    /**
     * Convert XML data to HTML
     *
     * @param string $data The XML data string to convert.
     * @param array  $options The options for rendering output.
     * @return string
     */
    public function to_html( string $data, array $options = array() ): string;

    /**
     * Set the options to be passed to the XSLTProcessor.
     *
     * @param array $options The options to be passed to the XSLTProcessor.
     * @return void
     */
    public function set_options( array $options ): void;

    /**
     * Set a single option.
     *
     * @param string $key The option key.
     * @param mixed  $value The option value.
     * @return void
     */
    public function set_option( string $key, mixed $value ): void;
}
