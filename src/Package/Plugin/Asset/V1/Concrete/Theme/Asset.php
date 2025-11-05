<?php
namespace Ababilithub\FlexAahub\Package\Plugin\Asset\V1\Concrete\Theme;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexWordpress\Package\Mixin\V1\Standard\Mixin as StandardWpMixin,
    FlexWordpress\Package\Asset\V1\Base\Asset as BaseAsset,
    FlexWordpress\Package\Notice\V1\Factory\Notice as NoticeFactory,
    FlexWordpress\Package\Notice\V1\Concrete\Transient\Notice as TransientNotice,
    FlexWordpress\Package\Query\V1\Cascade\Taxonomy\V1\Factory\Query as TaxonomyQueryFactory,
    FlexWordpress\Package\Template\V1\Factory\Template as TemplateFactory,
    FlexWordpress\Package\Template\V1\Concrete\List\Masonry\Template as MasonryListTemplate,
    FlexWordpress\Package\Template\V1\Concrete\List\PremiumCard\Template as PremiumCardListTemplate,
};

use const Ababilithub\{
    FlexAahub\PLUGIN_PRE_UNDS,
    FlexAahub\PLUGIN_PRE_HYPH,
};

class Asset extends BaseAsset
{
    use  StandardWpMixin;
    
    public function init($data = []): static
    {
        $this->init_hook();
        $this->init_service();
        return $this;
    }

    public function init_hook(): void
    {
        $this->asset_base_url = $this->get_url('Asset/');
        $this->asset_base_prefix = 'ababilithub-flex-multilingual-ebook';

        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        add_action(PLUGIN_PRE_UNDS.'_renderable', [$this, 'renderable']);
        // Logged-in users
        add_action('wp_ajax_get_child_terms', [$this, 'get_child_terms']);
        add_action('wp_ajax_nopriv_get_child_terms', [$this, 'get_child_terms']);
        
    }

    public function init_service(): void
    {
        //$this->template = TemplateFactory::get(MasonryListTemplate::class);
        $this->notice_board = NoticeFactory::get(TransientNotice::class);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-slider');

        // wp_enqueue_script(
        //     $this->asset_base_prefix.'app-script', 
        //     $this->asset_base_url.'App/Js/Script.js',
        //     array('jquery', 'jquery-ui-slider'), 
        //     time(), 
        //     true
        // );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-theme-style', 
            $this->asset_base_url.'Appearence/Theme/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-animation-style', 
            $this->asset_base_url.'Appearence/Animation/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-component-title-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Component/Title/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-component-rating-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Component/Rating/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-component-cover-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Component/Cover/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-component-cover-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Component/Cover/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-component-author-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Component/Author/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-header-component-bookinfo-component-publisher-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Header/Component/BookInfo/Component/Publisher/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-sidebar-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Sidebar/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-sidebar-component-h2-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Sidebar/Component/H2/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-sidebar-component-accordion-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Sidebar/Component/Accordion/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-sidebar-component-search-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Sidebar/Component/Search/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-main-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Main/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-main-component-toggle-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Main/Component/Toggle/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-main-component-content-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Main/Component/Content/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-main-component-content-code-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Main/Component/Content/Code/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-template-page-layout-ebook-layoutitem-footer-style', 
            $this->asset_base_url.'Appearence/Template/Page/Layout/Ebook/LayoutItem/Footer/Css/Style.css',
            array(), 
            time()
        );

        wp_enqueue_style(
            $this->asset_base_prefix.'app-component-table-style', 
            $this->asset_base_url.'Appearence/Component/Table/Css/Style.css',
            array(), 
            time()
        );



        wp_register_script(
            $this->asset_base_prefix.'-app-module-script', 
            $this->asset_base_url.'Js/Main/Index.js',
            [], // modules handle their own imports, so dependencies usually empty
            time(),
            true
        );

        // Add type="module"
        //wp_script_add_data($this->asset_base_prefix.'-app-module-script', 'type', 'module');
        // Add type="module"
        add_filter('script_loader_tag', function($tag, $handle, $src): mixed {
            if ($handle === $this->asset_base_prefix . '-app-module-script') 
            {
                return '<script type="module" src="' . esc_url($src) . '" id="' . $handle . '-js"></script>';
            }
            return $tag;
        }, 10, 3);

        // Enqueue it
        wp_enqueue_script($this->asset_base_prefix.'-app-module-script');

        $file_path = plugin_dir_path(__FILE__) . 'Asset/Data/ebook.json';
        
        wp_localize_script(
            $this->asset_base_prefix . '-app-module-script',
            'flexMultilingualEbook',
            // $this->asset_base_prefix.'localize-script', 
            // $this->asset_base_prefix.'_localize_script', 
            array(
                'adminAjaxUrl' => admin_url('admin-ajax.php'),
                'ajaxNonce' => wp_create_nonce($this->asset_base_prefix.'_nonce'),
                'dataUrl' => $this->asset_base_url . 'Data/ebook.json',
                'data' => file_get_contents($file_path),
                
            )
        );
    }

    public function render(array $attributes): string
    {
        $this->set_attributes($attributes);
        $params = $this->get_attributes();
        
        ob_start();
        do_action(PLUGIN_PRE_UNDS.'_renderable', $params);
        return ob_get_clean();
    }

    public function register(): void
    {

    }
    
}