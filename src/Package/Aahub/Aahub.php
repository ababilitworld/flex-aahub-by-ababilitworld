<?php
    namespace Ababilithub\FlexAahub\Package\Aahub;

    (defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

	use Ababilithub\{
		FlexPhp\Package\Mixin\V1\Standard\Mixin as StandardMixin
	};

	if ( ! class_exists( __NAMESPACE__.'\Aahub' ) ) 
	{
		/**
		 * Class Aahub
		 *
		 * @package \Ababilithub\FlexAahub\Package\Aahub
		 */
		class Aahub 
		{
			use StandardMixin;
	
			/**
			 * Constructor
			 */
			public function __construct() 
			{
				
			}
	
		}
	}
?>