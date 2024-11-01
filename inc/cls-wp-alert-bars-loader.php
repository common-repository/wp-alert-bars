<?php
/**
 * General action, hooks loader
*/
class WAB_Loader {

	protected $wab_actions;
	protected $wab_filters;

	/**
	 * Class Constructor
	*/
	function __construct(){
		$this->wab_actions = array();
		$this->wab_filters = array();
	}

	function add_action( $hook, $component, $callback ){
		$this->wab_actions = $this->add( $this->wab_actions, $hook, $component, $callback );
	}

	function add_filter( $hook, $component, $callback ){
		$this->wab_filters = $this->add( $this->wab_filters, $hook, $component, $callback );
	}

	private function add( $hooks, $hook, $component, $callback ){
		$hooks[] = array( 'hook' => $hook, 'component' => $component, 'callback' => $callback );
		return $hooks;
	}

	public function wab_run(){
		foreach( $this->wab_filters as $hook ){
			add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
		foreach( $this->wab_actions as $hook ){
			add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ) );
		}
	}
}
?>