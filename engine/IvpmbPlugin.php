<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 04.03.2019
 * Time: 10:27
 */
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/ui/IvpmbAdminCore.php';

class IvpmbPlugin {
	private static $VERSION = '0.0.9';
	private $admin;

	public static function init($admin) {
		return new IvpmbPlugin($admin);
	}

	public function __construct(IvpmbAdmin $admin) {
		$this->admin = $admin;
		add_action('wp_enqueue_scripts', [$this, 'wpLoadScripts'], 50);
		add_action('admin_enqueue_scripts', [$this, 'adminLoadScripts']);
		if($this->admin->isActiveOnShopPage()) {
			add_action('woocommerce_after_shop_loop_item', [$this, 'activateOnShopPage'], 12);
		}
	}

	public function wpLoadScripts() {
		wp_enqueue_style('si-wp-styles', plugins_url('css/plugin.css',
			IVPMB_SPINNER_IMPROVED), [], self::$VERSION);
		//Enqueue the jQuery UI theme css file from google:
		wp_enqueue_style('e2b-admin-ui-css', plugins_url('css/jquery-ui.css', IVPMB_SPINNER_IMPROVED),
			[], self::$VERSION,false);
		wp_enqueue_script('si-ajax-script', plugins_url('js/plugin.js',
			IVPMB_SPINNER_IMPROVED), ['jquery', 'jquery-ui-spinner', 'wp-i18n'], self::$VERSION);
		wp_localize_script('si-ajax-script','ivbpmb_options', $this->getScriptData());
		IvpmbAdminCore::enqueueFont('iv_spinner_font');
	}

	public function getScriptData() {
		return ['activeOnCart' => $this->admin->isActiveOnCartPage(),
		        'activeOnSingleProductPage' => $this->admin->isActiveOnSingleProductPage(),
		        'activeOnShopPage' => $this->admin->isActiveOnShopPage(),
				'marginTop' => esc_attr(get_option('iv_spinner_margin_top')),
				'marginLeft' => esc_attr(get_option('iv_spinner_margin_left')),
				'marginBottom' => esc_attr(get_option('iv_spinner_margin_bottom')),
				'marginRight' => esc_attr(get_option('iv_spinner_margin_right')),
				'font' => esc_attr(IvpmbAdminCore::fontString(get_option('iv_spinner_font'))),
				'fontsize' => esc_attr(get_option('iv_spinner_font_size')),
				'color' => esc_attr(get_option('iv_spinner_color')),
				'background' => esc_attr(get_option('iv_spinner_background'))
				];
	}

	public function adminLoadScripts() {
		wp_enqueue_style('si-admin-styles', plugins_url('css/admin.css', IVPMB_SPINNER_IMPROVED),
			[], self::$VERSION);
		IvpmbAdminCore::adminLoadScripts();
	}

	public function activateOnShopPage() {
		$product = wc_get_product(get_the_ID());
		if (!$product->is_sold_individually()
		    && 'variable' != $product->get_type()
		    && 'outofstock' != $product->get_stock_status()) {
			woocommerce_quantity_input(
				['min_value' => 1,
				 'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity()]
			);
		}
	}
}