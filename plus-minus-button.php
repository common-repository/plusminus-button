<?php
/**
Plugin Name: PlusMinus Button
Description: Adds functionality to increase and decrease values of number inputs by +/- buttons.
Version: 0.0.5
Text Domain: plus-minus-button
Domain Path: /languages
*/
define('IVPMB_SPINNER_IMPROVED', __FILE__);

require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/IvpmbPlugin.php';
require_once dirname( IVPMB_SPINNER_IMPROVED ) . '/engine/IvpmbAdmin.php';

$admin = IvpmbAdmin::init();
IvpmbPlugin::init($admin);
