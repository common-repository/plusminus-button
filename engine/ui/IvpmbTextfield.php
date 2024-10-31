<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 29.03.2019
 * Time: 10:10
 */

class IvpmbTextfield {

	private $type;
	private $class;

	public function __construct($class = '', $type = 'text') {
		$this->class = $class;
		$this->type = $type;
	}

	public function create($args) {
		$id = $args['id'];
		$name = $args['name'];
		$value = $args['value'];
		printf("<input id='%s' class='iv-form-element textfield %s' name='%s' type='%s' value='%s' />", $id, $this->class, $name, $this->type, $value);
	}

}