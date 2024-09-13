<?php

namespace Ababilitworld\FlexHubByAbabilitworld;

class Bootstrap
{
    private $prefix;
    private $base_dir;

    public function __construct() 
    {
        add_action('admin_menu', array($this, 'admin_menu'));
    }

    public function include_files_in_directory($directory) 
    {
        $directory = rtrim($directory, '/') . '/';
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($directory),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) 
        {
            if ($file->isDir()) 
            {
                continue;
            }

            if (pathinfo($file, PATHINFO_EXTENSION) === 'php') 
            {
                $relative_path = str_replace([$this->base_dir, '.php'], '', $file->getPathname());
                $namespace = str_replace('/', '\\', $relative_path);
                require_once $file;
            }
        }
    }

    public function admin_menu() 
    {
        add_menu_page(
            'Loaded Classes',
            'Loaded Classes',
            'manage_options',
            'loaded-classes',
            array($this, 'display_loaded_classes'),
            'dashicons-admin-generic',
            9
        );
    }

    public function composer_autoload() 
    {
        if (file_exists(__DIR__ . '/vendor/autoload.php')) 
        {
            require __DIR__ . '/vendor/autoload.php';
        }
    }

    public function list_loaded_classes() 
    {
        $this->composer_autoload();
        return get_declared_classes();
    }

    public function display_loaded_classes() 
    {
        $classes = $this->list_loaded_classes();

        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Loaded Classes', 'textdomain') . '</h1>';
        
        foreach ($classes as $class) 
        {
            if( strpos($class,"Flex") !== false)
            {

                echo esc_html($class) . "<br>";
            }
        }
        echo '</div>';
    }
}

// Instantiate the autoload
$bootstrap = new Bootstrap();
$bootstrap->composer_autoload();

?>


