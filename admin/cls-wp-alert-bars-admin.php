<?php
/**
*	Admin Parent Class
*/
class WAB_Admin 
{	
	private $wab_version;
	private $wab_assets_prefix;

	function __construct( $version ){
		$this->wab_version = $version;
		$this->wab_assets_prefix = substr(WAB_PRFX, 0, -1) . '-';
	}
	
	/**
	*	Loading the admin menu
	*/
	public function wab_admin_menu(){
		
		add_menu_page(	esc_html__('WP Alert Bar', WAB_TXT_DOMAIN),
						esc_html__('WP Alert Bar', WAB_TXT_DOMAIN),
						'manage_options', // area of the admin panel
						'wab-admin-panel',
						array( $this, WAB_PRFX . 'load_admin_panel' ),
						'dashicons-archive',
						100 
					);
	}
	
	/**
	*	Loading admin panel assets
	*/
	function wab_enqueue_assets(){
		if (isset($_GET['page']) && $_GET['page'] == 'wab-admin-panel'){
			wp_enqueue_style(
								$this->wab_assets_prefix . 'admin-style',
								WAB_ASSETS . 'css/' . $this->wab_assets_prefix . 'admin-style.css',
								array(),
								$this->wab_version,
								FALSE
							);
			
			wp_enqueue_style('wp-color-picker');
			wp_enqueue_script('wp-color-picker');

			if ( !wp_script_is( 'jquery' ) ) {
				wp_enqueue_script('jquery');
			}
			wp_enqueue_script(
								$this->wab_assets_prefix . 'admin-script',
								WAB_ASSETS . 'js/' . $this->wab_assets_prefix . 'admin-script.js',
								array('jquery'),
								$this->wab_version,
								TRUE
							);
			$wab_settings = get_option('wab_settings');
			if(!is_array($wab_settings)){
				$wab_settings = array(0, 1);
			}
			$wabColorPickerId = "";
			$wabAdminArray = array(
				'wabIdsOfColorPicker' => array()
			);
			for($i=0; $i<count($wab_settings); $i++){
				$wabAdminArray['wabIdsOfColorPicker'][] = "#wab_bg_color_{$i}";
			}
			
			// handler, jsObject, data
			wp_localize_script( 'wab-admin-script', 'wabAdminScript', $wabAdminArray );
		}
	}
	
	/**
	*	Loading admin panel view/forms
	*/
	function wab_load_admin_panel(){
		require_once WAB_PATH . 'admin/view/' . $this->wab_assets_prefix . 'settings.php';
	}

	protected function wab_display_notification($type, $msg){ ?>
		<div class="wab-alert <?php printf('%s', $type); ?>">
			<span class="wab-closebtn">&times;</span> 
			<strong><?php esc_html_e(ucfirst($type), WAB_TXT_DOMAIN); ?>!</strong> <?php esc_html_e($msg, WAB_TXT_DOMAIN); ?>
		</div>
	<?php }
}
?>