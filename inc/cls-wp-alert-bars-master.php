<?php
/**
 * Our main plugin class
*/
class WAB_Master {

	protected $wab_loader;
	protected $wab_version;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->wab_version = WAB_VERSION;
		add_action('plugins_loaded', array($this, 'wab_load_plugin_textdomain'));
		$this->wab_load_dependencies();
		$this->wab_trigger_admin_hooks();
		$this->wab_trigger_front_hooks();
	}

	function wab_load_plugin_textdomain(){
		load_plugin_textdomain( WAB_TXT_DOMAIN, FALSE, WAB_TXT_DOMAIN . '/languages/' );
	}

	private function wab_load_dependencies(){
		require_once WAB_PATH . 'admin/' . WAB_CLS_PRFX . '-admin.php';
		require_once WAB_PATH . 'front/' . WAB_CLS_PRFX . '-front.php';
		require_once WAB_PATH . 'inc/' . WAB_CLS_PRFX . '-loader.php';
		$this->wab_loader = new WAB_Loader();
	}

	private function wab_trigger_admin_hooks(){
		$wab_admin = new WAB_Admin($this->wab_version());
		$this->wab_loader->add_action( 'admin_menu', $wab_admin, WAB_PRFX . 'admin_menu' );
		$this->wab_loader->add_action( 'admin_enqueue_scripts', $wab_admin, WAB_PRFX . 'enqueue_assets' );
	}

	function wab_trigger_front_hooks(){
		$wab_front = new WAB_Front($this->wab_version());
		$this->wab_loader->add_action( 'wp_enqueue_scripts', $wab_front, WAB_PRFX . 'front_assets' );
		$wab_front->wab_load_shortcode();
	}

	function wab_run(){
		$this->wab_loader->wab_run();
	}

	function wab_version(){
		return $this->wab_version;
	}

	function wab_unregister_settings(){
		global $wpdb;
	
		$tbl = $wpdb->prefix . 'options';
		$search_string = WAB_PRFX . '%';
		
		$sql = $wpdb->prepare( "SELECT option_name FROM $tbl WHERE option_name LIKE %s", $search_string );
		$options = $wpdb->get_results( $sql , OBJECT );
	
		if(is_array($options) && count($options)) {
			foreach( $options as $option ) {
				delete_option( $option->option_name );
				delete_site_option( $option->option_name );
			}
		}
	}
}
?>
