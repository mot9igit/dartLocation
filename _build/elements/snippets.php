<?php

return [
    'dl.geo_data' => [
        'file' => 'dl.geo_data',
        'description' => 'dartLocation snippet to show geodata on the page',
        'properties' => [
            'tpl' => [
                'type' => 'textfield',
                'value' => 'dl.geodata',
            ],
            'modal_tpl' => [
                'type' => 'textfield',
                'value' => 'dl.modal',
            ],
            'toPlaceholder' => [
                'type' => 'combo-boolean',
                'value' => false,
            ],
        ],
    ],
	'dl.get_cities' => [
		'file' => 'dl.get_cities',
		'description' => 'dartLocation snippet to list filled cities on the page',
		'properties' => [
			'tpl' => [
				'type' => 'textfield',
				'value' => 'dl.cities',
			]
		],
	]
];