<?php
/**
 * XSL Formatter
 *
 * This class provides functionality to convert XML data to HTML using XSL transformation.
 *
 * @package OrcidDataBlock\Formatter
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Formatter;

use DOMDocument;
use MESH\OrcidDataBlock\Contracts\FormatterContract;
use XSLTProcessor;

/**
 * XSL Formatter class
 */
class XslFormatter extends BaseFormatter implements FormatterContract {
    /**
     * The path to the XSL file.
     *
     * @var string
     */
    private $xsl_file;

    /**
     * XslFormatter constructor.
     *
     * @param string $xsl_file The path to the XSL file.
     */
    public function __construct( string $xsl_file ) {
        $this->xsl_file = $xsl_file;
        parent::__construct();
    }

    /**
     * Convert XML data to HTML.
     *
     * @param string $data The XML data string to convert.
     * @param array  $options The options to be passed to the XSLTProcessor.
     * @return string The converted HTML string.
     */
    public function to_html( $data, $options = array() ): string {
        $options = array_merge($this->options, $options);

        $xml_doc = new DOMDocument();
        $xml_doc->loadXML($data);

        $xsl_doc = new DOMDocument();
        $xsl_doc->load($this->xsl_file);


        $html_doc = new XSLTProcessor();
        $html_doc->setParameter('', $options);
        $html_doc->importStylesheet($xsl_doc);

        return $html_doc->transformToXML($xml_doc);
    }
}
