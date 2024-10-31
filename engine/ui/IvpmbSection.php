<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 13:17
 */
require_once( 'IvpmbSettingsField.php' );

class IvpmbSection {
	private $sectionName;
	private $page;
	private $settingsFields;
	private $title;
	private $slug;

	public function __construct($sectionName, $page, $title, $slug, $settingsFields) {
		$this->sectionName = $sectionName;
		$this->page = $page;
		$this->title = $title;
		$this->slug = $slug;
		$this->settingsFields = $settingsFields;
	}

	public function settingsInit() {
		$this->initSection();
		foreach($this->settingsFields as $settingsField) {
			$settingsField->initField();
		}
	}

	private function initSection() {
		$callback = [$this, 'sectionSlug'];
		add_settings_section($this->sectionName, $this->title, $callback, $this->page);
	}

	public function sectionSlug() {
		echo($this->slug);
	}

	public function output() {
		settings_fields($this->page);
		do_settings_sections($this->page);
	}
}