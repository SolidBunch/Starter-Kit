<?php

use StarterKit\Helper\Utils;

return [
	'name'            => esc_html__( 'Form Text Field with Datepicker', 'starter-kit' ),
	'base'            => 'form_text_datepicker',
	'icon'            => Utils::getConfigSetting( 'shortcodes_icon_uri' ) . 'calendar.svg',
	'content_element' => true,
	'category'        => esc_html__( 'Form Fields', 'starter-kit' ),
	'as_child'        => [
		'only' => 'contact_form, vc_column_inner'
	],
	'params'          => [
		
		[
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Field name', 'starter-kit' ),
			'description' => esc_html__( 'Enter a field name for Humans', 'starter-kit' ),
			'param_name'  => 'label',
			'holder'      => 'h2',
			'value'       => '',
		],
		[
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Placeholder', 'starter-kit' ),
			'description' => esc_html__( 'This text will be used as field placeholder', 'starter-kit' ),
			'param_name'  => 'placeholder',
			'value'       => '',
		],
		[
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Mandatory Field', 'starter-kit' ),
			'description' => esc_html__( 'Make this field mandatory?', 'starter-kit' ),
			'param_name'  => 'required',
			'value'       => [ esc_html__( 'Yes', 'starter-kit' ) => 'yes' ],
		],
		[
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Create event in Google Calendar', 'starter-kit' ),
			'param_name' => 'create_event',
			'value'      => [ esc_html__( 'Yes', 'starter-kit' ) => 'yes' ],
		],
		[
			'type'        => 'el_id',
			'heading'     => esc_html__( 'Field ID', 'starter-kit' ),
			'param_name'  => 'el_id',
			'settings'    => [
				'auto_generate' => true,
			],
			'description' => esc_html__( 'Used in "name" attribute', 'starter-kit' ),
		],
	]
];