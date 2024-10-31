<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 10:41
 */

class IvpmbSettingsField {
	private $caption;
	private $field;
	private $id;
	private $page;
	private $sectionName;

	public function __construct($id, $page, $sectionName, $field, $caption) {
		$this->caption = $caption;
		$this->field = $field;
		$this->id = $id;
		$this->page = $page;
		$this->sectionName = $sectionName;
	}

	public function initField() {
		$callback = [$this, 'create'];
		add_settings_field($this->id, $this->caption, $callback, $this->page, $this->sectionName);
		register_setting($this->page, $this->id, [$this, 'validateInput']);
	}

	public function create() {
		$value = $this->getValue();
		$args = ['id' => $this->id, 'name' => $this->id, 'value' => $value];
		$this->field->create($args);
	}

	public function getValue() {
		return $this->sanitize(get_option($this->id));
	}

	private function sanitize($value) {
		return esc_attr($value);
	}

	public function validateInput($input) {
		return esc_attr($input);
	}

}