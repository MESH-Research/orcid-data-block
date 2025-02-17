<?php
/**
 * Controller class
 *
 * @package OrcidDataBlock
 */

declare(strict_types=1);

namespace MESH\OrcidDataBlock\Controller;

/**
 * Controller base class
 */
class Controller {
    /**
     * Template data to be set to the view
     *
     * @var array
     */
    private $data = array();

    /**
     * Controller instance
     *
     * @var Controller
     */
    private static $instance;

    /**
     * Set the data to be used in the view
     *
     * @param string $key Key.
     * @param mixed  $value Value.
     * @return void
     */
    protected function set( $key, $value ) {
        $this->data[ $key ] = $value;
    }

    /**
     * Render the template
     *
     * @param string $template Template slug.
     * @return string
     */
    public function render( string $template ): string {
        ob_start();

        //phpcs:ignore WordPress.PHP.DontExtract.extract_extract
        extract($this->data);
        require $this->get_view_path($template);

        return ob_get_clean();
    }

    /**
     * Get the template path.
     *
     * @param string $template Template slug.
     * @return string
     */
    private function get_view_path( string $template ): string {
        return ORCID_DATA_BLOCK_DIR . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $template . '.php';
    }

    /**
     * Handle the view
     *
     * @param mixed ...$deps Dependencies for the controller to be passed to its constructor.
     * @return Controller
     */
    public static function startup( ...$deps ): Controller {
        if (null === self::$instance) {
            self::$instance = new static(...$deps);
        }
        return self::$instance;
    }

    /**
     * Handle the view
     *
     * @param string $view View method.
     */
    public function handle( string $view ): void {
        $output = self::$instance->$view();

        if (!empty($output)) {
            echo $output;
        } else {
            echo self::$instance->render($view);
        }
    }
}
