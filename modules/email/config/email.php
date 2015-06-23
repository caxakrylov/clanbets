<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	Kohana::DEVELOPMENT => array
	(
		'default' => array(
			'driver'     => 'smtp',
			'hostname'   => 'smtp.yandex.ru',
			'username'   => 'noreply@clanbets.com',
			'password'   => 'YLsA7VOJm1',
			'encryption' => 'ssl',
			'port'	       => '465'
		)
	),
	Kohana::PRODUCTION  => array
	(
		'default' => array(
			'driver'     => 'smtp',
			'hostname'   => 'smtp.yandex.ru',
			'username'   => 'noreply@clanbets.com',
			'password'   => 'YLsA7VOJm1',
			'encryption' => 'ssl',
			'port'	       => '465'

		)
	),
);
