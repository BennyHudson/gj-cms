<?php
/**
 * Timber Lydia Context
 * --------
 * @category Timber
 * @version 1.0
 * @package Lydia
 */

namespace BMAS\Timber;

defined('ABSPATH') || exit;

use Timber\Timber as Timber;
use BMAS\Util\Console as Console;

/**
 * Class LydiaContext
 * Utility to create template context objects
 * Gets initial context and allows for extending via add() method
 *
 * @package BMAS
 */
class Context
{
    /**
     * @var mixed
     */
    public $context;

    /**
     * @var mixed
     */
    private $templates;

    /**
     * LydiaContext constructor.
     * pass in the templates and let the class do the rest.
     * when ready, use the render() method to render twig file
     * @param array $templates - list of twig template files
     * @param array $context - a partial context
     */
    public function __construct(
        $templates,
        $context = null
    ) {
        $this->context = isset($context) ? $context : Timber::context();

        if (!in_array('index.twig', $templates)) {
            array_push($templates, 'index.twig');
        }
        $this->templates = $templates;
    }

    /**
     * Add one or more properties to context
     * @param array $contextArray
     */
    public function add($context, $value = '')
    {
        if (is_array($context)) {
            $this->context = array_merge($this->context, $context);
        } else {
            $this->context[$context] = $value;
        }
    }

    /**
     * Compile the template to a string and return
     * @return string
     */
    public function compile(): string
    {
        return Timber::compile($this->templates, $this->context);
    }

    /**
     * Get the context object
     * @return array
     */
    public function get()
    {
        return $this->context;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getValue($name)
    {
        return $this->context[$name];
    }

    /**
     * Convenience function to use consoleTwig to log
     */
    public function log()
    {
        $log = Console::log('Current Context: ', $this->context);
        $log .= Console::log('Templates: ', $this->templates);

        return $log;
    }

    /**
     * Render the template using Timber::render
     */
    public function render()
    {

        if ((defined('WP_DEBUG') && true === WP_DEBUG) && !is_admin()) {
            $this->context['DEV_DEBUG'] = $this->log();
        }

        Timber::render($this->templates, $this->context);
    }
}
