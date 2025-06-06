<?php
namespace Ababilithub\FlexAahub\Package;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilithub\{
    FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin
};

use const Ababilithub\{
    FlexAahub\PLUGIN_NAME,
    FlexAahub\PLUGIN_FILE,
    FlexAahub\PLUGIN_DIR,
    FlexAahub\PLUGIN_URL,
    FlexAahub\PLUGIN_VERSION
};

if (!class_exists(__NAMESPACE__.'\Package')) 
{
    /**
     * Class Package
     *
     * @package Ababilithub\FlexAahub\Package\Package
     */
    class Package
    {
        use StandardMixin;

        /**
         * Package version
         *
         * @var string
         */
        public $version = '1.0.0';

        /**
         * Constructor
         */
        public function __construct()
        {
            register_uninstall_hook(PLUGIN_FILE, array('self', 'uninstall'));
        }

        /**
         * Run the installer
         * 
         * @return void
         */
        public static function run()
        {
            $installed = get_option(PLUGIN_NAME . '-installed');

            if (!$installed) {
                update_option(PLUGIN_NAME . '-installed', time());
            }

            update_option(PLUGIN_NAME . '-version', PLUGIN_VERSION);
        }

        /**
         * Activate the class
         *
         * @return void
         */
        public static function activate(): void
        {
            //flush_rewrite_rules();
            self::run();
        }

        /**
         * Deactivate the class
         *
         * @return void
         */
        public static function deactivate(): void
        {
            //flush_rewrite_rules();
            ;
        }

        /**
         * Uninstall the plugin
         *
         * @return void
         */
        public static function uninstall(): void
        {
            delete_option(PLUGIN_NAME . '-installed');
            delete_option(PLUGIN_NAME . '-version');
            flush_rewrite_rules();
        }
    }
}
