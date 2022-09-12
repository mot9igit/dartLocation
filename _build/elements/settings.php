<?php

return [
	'frontend_css' => [
		'xtype' => 'textfield',
		'value' => '[[+cssUrl]]web/dartlocation.css',
		'area' => 'shoplogistic_main',
	],
	'frontend_js' => [
		'xtype' => 'textfield',
		'value' => '[[+jsUrl]]web/dartlocation.js',
		'area' => 'shoplogistic_main',
	],
	'api_key_dadata' => [
		'xtype' => 'textfield',
		'value' => '',
		'area' => 'shoplogistic_eshoplogistic',
	],
	'secret_key_dadata' => [
		'xtype' => 'textfield',
		'value' => '',
		'area' => 'shoplogistic_eshoplogistic',
	],
	'phx_prefix' => [
		'xtype' => 'textfield',
		'value' => 'dl.',
		'area' => 'shoplogistic_city',
	],
	'city_fields' => [
		'xtype' => 'textfield',
		'value' => 'key,city,phone,email',
		'area' => 'shoplogistic_city',
	],
];