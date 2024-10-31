<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 09:54
 */

class IvpmbImage {

	private static $IMAGES = ['iv_spinner_activate_on_shop_page' => [true => 'shop_active_', false => 'shop_inactive_'],
	                          'iv_spinner_activate_on_cart' => [true => 'cart_active_', false => 'cart_inactive_'],
	                          'iv_spinner_activate_on_single_product_page' => [true => 'single_product_page_active_', false => 'single_product_page_inactive_']];

	public function applyImage($id, $name, $checked) {
		$selected = $checked ? 'checked' : 'unchecked';
		$labelId = $id . '_' . $selected;
		$class = 'iv-spinner-admin-' . $selected;
		$src = $this->getImageSrc($name, $checked);
		printf("<label for='%s' id='%s' class='%s'><img src='%s' /></label>", $name, $labelId, $class, $src);
	}

	private function getImageSrc($name, $checked) {
		$locale = get_locale();
		$image = self::$IMAGES[$name];
		$src = plugin_dir_url(IVPMB_SPINNER_IMPROVED) . 'images/' . $image[$checked] . $locale . '.jpg';
		if (!@getimagesize($src)) {
			$src = plugin_dir_url(IVPMB_SPINNER_IMPROVED) . 'images/' . $image[$checked] . 'de_DE.jpg';
		}
		return $src;
	}

}