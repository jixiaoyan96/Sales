<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'LBS Daily Management - UAT',
	'timeZone'=>'Asia/Hong_Kong',
	'sourceLanguage'=> 'en',
	'language'=>'zh_cn',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.YiiMailer.YiiMailer',
	),

	// application components
	'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=salesuat',
			'emulatePrepare' => true,
			'username' => 'swuser',
			'password' => 'Swisher@168',
			'charset' => 'utf8',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		'systemEmail'=>'it@lbsgroup.com.hk',
		'webroot'=>'http://118.89.46.224/sa-uat',
		'envSuffix'=>'uat',
		'systemId'=>'sal',
		'onesignal'=>'3183638f-c26a-409c-a80a-00736ae8a772',
		'onesignalKey'=>'ODk5Yjk0ZjAtYTc1ZS00ODM1LTg1OWQtNWM1OTgyNzkxOGQy',
	),
);
