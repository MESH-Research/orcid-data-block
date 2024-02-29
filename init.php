<?php
/**
 * Orcid Data Block
 *
 * @package OrcidDataBlock
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock;

use MESH\OrcidDataBlock\Cache\WPTransientCache;
use MESH\OrcidDataBlock\Client\OrcidClient;
use MESH\OrcidDataBlock\Formatter\XslFormatter;

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

if (!defined('ORCID_DATA_BLOCK_DIR')) {
    define('ORCID_DATA_BLOCK_DIR', plugin_dir_path(__FILE__));
}

if (!defined('ORCID_DATA_BLOCK_URL')) {
    define('ORCID_DATA_BLOCK_URL', plugin_dir_url(__FILE__));
}

if (!defined('ORCID_DATA_BLOCK_FILE')) {
    define('ORCID_DATA_BLOCK_FILE', __FILE__);
}

require_once __DIR__ . '/lib/autoload.php';

OrcidDataBlock::boot(
    new OrcidClient(new WPTransientCache(24 * 60 * 60 * 1)),
    new XslFormatter(ORCID_DATA_BLOCK_DIR . 'orcid-data-all.xsl')
);
