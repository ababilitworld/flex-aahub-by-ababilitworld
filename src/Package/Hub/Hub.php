<?php
    namespace Ababilitworld\FlexHubByAbabilitworld\Package\Hub;

    (defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

	use Ababilitworld\FlexTraitByAbabilitworld\Standard\Standard;

	if ( ! class_exists( __NAMESPACE__.'\Hub' ) ) 
	{
		/**
		 * Class Hub
		 *
		 * @package \Ababilitworld\FlexHubByAbabilitworld\Package\Hub
		 */
		class Hub 
		{
			use Standard;
	
			/**
			 * Constructor
			 */
			public function __construct() 
			{
				
			}
	
		}
	}
	
?>