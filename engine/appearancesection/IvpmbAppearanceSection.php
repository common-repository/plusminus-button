<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 13:17
 */
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/appearancesection/IvpmbAppearanceSettingsField.php';

class IvpmbAppearanceSection {
	public static $SECTION_NAME = 'iv_spinner_settings_section';
	public static $PAGE = 'iv_spinner_settings_page';
	private $shopPageField;
	private $cartPageField;
	private $singleProductPageField;

	public function __construct() {
		$this->shopPageField = new IvpmbAppearanceSettingsField('iv_spinner_activate_on_shop_page', self::$PAGE, self::$SECTION_NAME);
		$this->cartPageField = new IvpmbAppearanceSettingsField('iv_spinner_activate_on_cart', self::$PAGE, self::$SECTION_NAME);
		$this->singleProductPageField = new IvpmbAppearanceSettingsField('iv_spinner_activate_on_single_product_page', self::$PAGE, self::$SECTION_NAME);
	}

	public function settingsInit() {
		$this->initSection();
		$this->shopPageField->initField();
		$this->cartPageField->initField();
		$this->singleProductPageField->initField();
	}

	private function initSection() {
		$title = __('iv-spinner-section-title', 'plus-minus-button');
		$callback = [$this, 'sectionSlug'];
		add_settings_section(self::$SECTION_NAME, $title, $callback, self::$PAGE);
	}

	public function sectionSlug() {
		_e('iv-spinner-section-slug', 'plus-minus-button');
	}

	public function output() {
		settings_fields(self::$PAGE);
		do_settings_sections(self::$PAGE);
	}

	public function isActiveOnShopPage() {
		return $this->shopPageField->isChecked();
	}

	public function isActiveOnCartPage() {
		return $this->cartPageField->isChecked();
	}

	public function isActiveOnSingleProductPage() {
		return $this->singleProductPageField->isChecked();
	}

}