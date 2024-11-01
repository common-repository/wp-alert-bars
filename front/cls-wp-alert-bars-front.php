<?php
/**
*	Front Parent Class
*/
class WAB_Front 
{	
	private $wab_version;

	function __construct( $version ){
		$this->wab_version = $version;
		$this->wab_assets_prefix = substr(WAB_PRFX, 0, -1) . '-';
	}
	
	function wab_front_assets(){
		wp_enqueue_style(	'wab-front-style',
							WAB_ASSETS . 'css/' . $this->wab_assets_prefix . 'front-style.css',
							array(),
							$this->wab_version,
							FALSE );
		if ( !wp_script_is( 'jquery' ) ) {
			wp_enqueue_script('jquery');
		}
		wp_enqueue_script(  'wab-front-script',
							WAB_ASSETS . 'js/wab-front-script.js',
							array('jquery'),
							$this->wab_version,
							TRUE );
	}

	function wab_load_shortcode(){
		add_shortcode( 'wp_alert_bars', array( $this, 'wab_load_shortcode_view' ) );
	}
	
	function wab_load_shortcode_view($wabAttr){
		$output = '';
		ob_start();
		include WAB_PATH . 'front/view/' . $this->wab_assets_prefix . 'front-view.php';
		$output .= ob_get_clean();
		return $output;
	}
}
?>