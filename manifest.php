<?php

return array(
	'name' => 'ai-ezpublish',
	'depends' => array(
		'aimeos-core',
	),
	'include' => array(
		'lib/custom/src',
	),
	'config' => array(
		'lib/custom/config',
	),
	'setup' => array(
		'lib/custom/setup',
	),
);
