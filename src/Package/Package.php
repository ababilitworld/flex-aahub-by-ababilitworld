<?php
namespace Ababilitworld\FlexHubByAbabilitworld\Package;

(defined('ABSPATH') && defined('WPINC')) || die();

use Ababilitworld\FlexTraitByAbabilitworld\Standard\Standard;

use const Ababilitworld\FlexHubByAbabilitworld\{
    PLUGIN_NAME,
    PLUGIN_FILE,
    PLUGIN_DIR,
    PLUGIN_URL,
    PLUGIN_VERSION
};

if (!class_exists(__NAMESPACE__.'\Package')) 
{
    /**
     * Class Package
     *
     * @package Ababilitworld\FlexHubByAbabilitworld\Package\Package
     */
    class Package
    {
        use Standard;

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
