<?php
/*
Optional parameters:
`scope`, `state`, `access_type`, `approval_prompt`
*/

return array(
	'path' => '/authvel/login',
	'callback_url' => '/authvel/login/callback',
	'callback_transport' => 'post',
	'security_salt' => 'your_salt_sxdcfvghbjn',
	'debug' => false,
		'Strategy' => array(
			'Twitter' => array(
				'key' => 'twitter_key',
				'secret' => 'twitter_secret'
			),
			'Facebook' => array(
				'app_id' => 'app_id',
				'app_secret' => 'app_secret'
			),
			'Google' => array(
				'client_id' => 'client_id',
				'client_secret' => 'AIzaSyDK-Dp03fWyFnQ5daiA-_-OdnEAd9IVqbM'
			)
		)
	);

?>