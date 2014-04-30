<?php defined('SYSPATH') OR die('No direct script access.');

return array(
    'envName' => 'dev',
	'recurly' => array(
		'subdomain' => 'peace',
		'apiKey' => 'af6c8ef1175b47679f8801669621615d'
		//		'subdomain' => 'rkm-developer-test',
        //		'apiKey' => '94a0955e63c648a8ac3e67442aaad7ee'
	),
	'wufoo' => array(
		'apiKey' => '74QT-C7JD-W0FN-Z9TH'
	),
	'api' => array(
		'url' => array(
			'install' => 'http://dev-socialapps.rkm-group.com/app/default/install/',
			'updateSubscriber' => 'http://dev-socialapps.rkm-group.com/authorize/subscriber/',
			'authorize' => 'http://dev-socialapps.rkm-group.com/authorize/isSubscriber/'
		),
		'APIKey' => 'k7GQOxXwF12',
		'APIPassword' => 'z6qBsdDziF'
	)
);