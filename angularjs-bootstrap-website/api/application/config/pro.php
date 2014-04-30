<?php defined('SYSPATH') OR die('No direct script access.');

return array(
    'envName' => 'prod',
	'recurly' => array(
		'subdomain' => 'north-social',
		'apiKey' => 'ce8e7260bcea44c8bfb7579e6995f84f'
	),
	'wufoo' => array(
		'apiKey' => 'MF01-NQNQ-LF4G-IYJE'
	),
	'api' => array(
		'url' => array(
			'install' => 'http://api-apps.com/app/default/install/',
			'updateSubscriber' => 'http://api-apps.com/authorize/subscriber/',
			'authorize' => 'http://api-apps.com/authorize/isSubscriber/'
		),
		'APIKey' => 'k7GQOxXwF12',
		'APIPassword' => 'z6qBsdDziF'
	)
);