<?php
namespace Ababilithub\FlexAahub\Package\Plugin\Asset\V1\Manager;

(defined('ABSPATH') && defined('WPINC')) || exit();

use Ababilithub\{
    FlexPhp\Package\Manager\V1\Base\Manager as BaseManager,
    FlexWordpress\Package\Asset\V1\Factory\Asset as AssetFactory,
    FlexWordpress\Package\Asset\V1\Contract\Asset as AssetContract,
    FlexAahub\Package\Plugin\Asset\V1\Concrete\Ebook\Asset as EbookAsset,
    
};

class Asset extends BaseManager
{
    public function __construct()
    {
        $this->init();
    }

    protected function init(): void
    {
        $this->set_items([
            EbookAsset::class,
            // Add more shortcode classes here...
        ]);
    }

    public function boot(): void 
    {
        foreach ($this->get_items() as $itemClass) 
        {
            $shortcode = AssetFactory::get($itemClass);

            if ($shortcode instanceof AssetContract) 
            {
                $shortcode->register();
            }
        }
    }
}
