<?php
    namespace Ababilitworld\FlexHubByAbabilitworld\Package\Hub\Service;

    (defined( 'ABSPATH' ) && defined( 'WPINC' )) || exit();

    use Ababilitworld\FlexTraitByAbabilitworld\Standard\Standard;

	if ( ! class_exists( __NAMESPACE__.'\Service' ) ) 
	{
		/**
		 * Class Service
		 *
		 * @package Ababilitworld\FlexHubByAbabilitworld\Package\Hub\Service\Service
		 */		
		class Service 
		{
            use Standard;
            
			public static function check_array_key_exists( $array, $keys ) 
			{
				if ( ! is_array( $array ) || ! is_array( $keys ) || empty( $keys ) ) 
				{
					return false;
				}
				
				$current_array = $array;
				
				foreach ( $keys as $key ) 
				{
					if ( isset( $current_array[ $key ] ) ) 
					{
						$current_array = $current_array[ $key ];
					}
					else 
					{
						return false;
					}
				}
				
				return true;
			}

			public static function sanitize_data( $data ) 
			{
				if ( is_array( $data ) ) 
				{
					foreach ( $data as $key => &$value ) 
					{
						if ( is_array( $value ) ) 
						{
							$value = self::sanitize_data( $value );
						}
						else
						{
							$value = sanitize_text_field( $value );
						}
					}
				}
				else
				{
					$data = sanitize_text_field( $data );
				}
				
				return $data;
			}

			public static function check_plugin($plugin_dir_name,$plugin_file): int 
			{
				include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
				$plugin_dir = ABSPATH . 'wp-content/plugins/'.$plugin_dir_name;
				if ( is_plugin_active( $plugin_dir_name.'/'.$plugin_file ) ) 
				{
					return 1;
				} 
				elseif ( is_dir( $plugin_dir ) ) 
				{
					return 2;
				} 
				else 
				{
					return 0;
				}
			}

			public static function install_plugin($plugin_file_url) 
			{
				include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
				include_once( ABSPATH . 'wp-admin/includes/file.php' );
				include_once( ABSPATH . 'wp-admin/includes/misc.php' );
				include_once( ABSPATH . 'wp-admin/includes/class-wp-upgrader.php' );
				$upgrader = new \Plugin_Upgrader( new \Plugin_Installer_Skin( compact( 'title', 'url', 'nonce', 'plugin', 'api' ) ) );
				$upgrader->install( $plugin_file_url );
				//$upgrader->install( 'https://github.com/magepeopleteam/magepeople-pdf-support/archive/master.zip' );
			}

			public static function download_and_extract_file($romote_file_url,$local_directory_path,$file_name) 
			{
				$local_directory_path = ABSPATH . 'wp-content/plugins/';
				$download_path = $local_directory_path . $file_name;
				$response = wp_remote_get( $romote_file_url, array( 'timeout' => 300 ) );

				if ( is_wp_error( $response ) )
				{
					echo 'Failed to download file: ' . $response->get_error_message();
				}
				else
				{
					$file_handle = fopen( $download_path, 'w' );
					fwrite( $file_handle, $response['body'] );
					fclose( $file_handle );
					$zip = new \ZipArchive;
					if ( $zip->open( $download_path ) === TRUE ) 
					{
						$zip->extractTo( $local_directory_path );
						$zip->close();
						echo 'File extracted successfully.';
					}
					else
					{
						echo 'Failed to extract file.';
					}

					unlink( $download_path );
				}
			}

			public function include_files_in_directory($base_dir,$directory) 
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
						$relative_path = str_replace([$base_dir, '.php'], '', $file->getPathname());
						$namespace = str_replace('/', '\\', $relative_path);
						require_once $file;
					}
				}
			}
	
		}

	}