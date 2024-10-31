<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 02.04.2019
 * Time: 13:47
 */

class IvpmbColorPicker {

	public function __construct() {
	}

	public function create($args) {
		$id = $args['id'];
		$name = $args['name'];
		$value = $args['value'];
		$class = 'iv-form-element textfield iv-colorpicker';
		$idlabel = $id . '_label';
		$onchange = "ivpmb_applyColor(\"$id\", \"$idlabel\")";
		$onkeyup = "ivpmb_applyColor(\"$idlabel\", \"$id\")";
		printf("<div>");
		printf("<input id='%s' class='%s' size='40' name='%s' type='color' value='%s' onchange='%s' />", $id, $class, $name, $value, $onchange);
		printf("<input id='%s' name='%s' size='30' type='text' value='%s' onkeyup='%s' />", $idlabel, $name, $value, $onkeyup);
		printf("</div>");
	}

}