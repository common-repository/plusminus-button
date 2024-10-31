<?php

class IvpmbAdminCore {
    private static $VERSION = '0.0.2';

    public static function adminLoadScripts() {
    	$file = plugins_url('js/jquery.fontselect.js', __FILE__);
    	if (@fopen($file, 'r')) {
		    wp_enqueue_script( 'fontselect-script', $file, [ 'jquery', 'wp-i18n' ], self::$VERSION );
		    wp_localize_script('fontselect-script','bundle', self::getScriptData());
	    }
	    $file = plugins_url('css/fontselect-alternate.css', __FILE__);
	    if (@fopen($file, 'r')) {
		    wp_enqueue_style( 'fontselect-style', $file, [], self::$VERSION );
	    }
	    $file = plugins_url('js/spectrum.js', __FILE__);
	    if (@fopen($file, 'r')) {
		    wp_enqueue_script( 'colorpicker-script', $file, [ 'jquery' ], self::$VERSION );
	    }
	    $file = plugins_url('css/spectrum.css', __FILE__);
	    if (@fopen($file, 'r')) {
		    wp_enqueue_style( 'colorpicker-style', $file, [], self::$VERSION );
	    }
	    wp_enqueue_script('admin-core-script', plugins_url('js/admin-core.js', __FILE__), ['jquery', 'jquery-ui-spinner'], self::$VERSION);
    }

    public static function getScriptData() {
    	return ['ivStylingSelectFont' => __('iv-styling-select-font', 'plus-minus-button')];
    }

	public static function enqueueFont($option) {
		$font = esc_attr(get_option($option));
		wp_enqueue_style($option, "https://fonts.googleapis.com/css?family=$font",false, self::$VERSION);
	}

	public static function fontString($font) {
		$result = str_replace('+', ' ', $font);
		return '\'' . $result . '\'';
	}

	public static function applyDashes($text) {
		return str_replace('_', '-', $text);
	}

}