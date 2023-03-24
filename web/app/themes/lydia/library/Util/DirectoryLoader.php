<?php
/**
 * Directory Loader
 * ------
 * This will iterate over the core folder to get all available php files recursively and includes them.
 * The beauty of this is you can have any folder structure you like to create independent, de-coupled modules that you want to use in your theme
 * -------
 * @category root
 * @version 1.0
 * @package Lydia
 */
namespace BMAS\Util;

defined( 'ABSPATH' ) || exit;

/**
 * Class DirectoryLoader
 * utility to load a full directory's files
 * @version 1.0.0
 */
class DirectoryLoader
{
    /**
     * @param $dir
     */
    public static function load( $dir = '')
    {
        $dir_iterator = new \RecursiveDirectoryIterator( get_template_directory() . '/' . $dir );
        self::loadFiles(
            new \RecursiveIteratorIterator(
                $dir_iterator, \RecursiveIteratorIterator::SELF_FIRST
            )
        );
    }

    /**
     * @param $iterator
     */
    public static function loadFiles( $iterator )
    {
        foreach ( $iterator as $file ) {
            // load all php EXCEPT for those beginning with __ which are excluded for files that need to be imported separately
            if ( $file->isFile() && preg_match( '/[^^__]\.php/', $file->getFileName() ) ) {
                include_once $file;
            }
        }
    }

    /**
     * @param $dirs
     */
    public static function loadSequence( $dirs )
    {
        foreach ( $dirs as $dir ) {
            self::load( $dir );
        }
    }
}
