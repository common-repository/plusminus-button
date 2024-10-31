<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 10:41
 */
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/appearancesection/IvpmbCheckbox.php';
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/ui/IvpmbAdminCore.php';

class IvpmbAppearanceSettingsField {
	private $checkbox;
	private $id;
	private $page;
	private $sectionName;

	public function __construct($id, $page, $sectionName) {
		$this->checkbox = new IvpmbCheckbox();
		$this->id = $id;
		$this->page = $page;
		$this->sectionName = $sectionName;
	}

	public function initField() {
		$caption = __(IvpmbAdminCore::applyDashes($this->id), 'plus-minus-button');
		$checked = $this->isChecked();
		$args = ['id' => $this->id, 'name' => $this->id, 'checked' => $checked];
		$callback = [$this->checkbox, 'createCheckbox'];
		add_settings_field($this->id, $caption, $callback, $this->page, $this->sectionName, $args);
		register_setting($this->page, $this->id, [$this, 'validateCheckboxInput']);
	}

	public function isChecked() {
		return $this->sanitize(get_option($this->id));
	}

	private function sanitize($checked) {
		if (esc_attr($checked) == "on") {
			return "on";
		}
		return "";
	}

	public function validateCheckboxInput($input) {
		if ($input == null || $input == 'on') {
			return $input;
		}
		return null;
	}
}