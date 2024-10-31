<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 10:10
 */
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/appearancesection/IvpmbImage.php';

class IvpmbCheckbox {
	private $image;

	public function __construct() {
		$this->image = new IvpmbImage();
	}

	public function createCheckbox($args) {
		$id = $args['id'];
		$name = $args['name'];
		if ($args['checked'] == 'on') {
			printf("<input id='%s' class='iv-form-element checkbox' name='%s' type='checkbox' checked />", $id, $name);
		} else {
			printf("<input id='%s' class='iv-form-element checkbox' name='%s' type='checkbox' />", $id, $name);
		}
		$this->image->applyImage($id, $name, true);
		$this->image->applyImage($id, $name, false);
	}

}