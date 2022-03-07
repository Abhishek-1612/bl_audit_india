<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

ini_set('session.gc_maxlifetime', 60*60*12);

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'IndiaMART\'s Global Admin',
	'defaultController' => 'DashBoard',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'ext.oci8Pdo.OciDbConnection',
		'ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'gl_mod',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1',$_SERVER['REMOTE_ADDR']),
			'newFileMode'=>0666,
			'newDirMode'=>0777,

		),
		//'admin_dashboard',
		//'admin_glusr',
		//'admin_products',
		//'admin_fcp',
		//'admin_query',
		'admin_eto',
		//'admin_vendor',
		//'admin_production',
		'admin_marketplace',
		//'admin_profile',
		'admin_bl',
		//'admin_administrator',
		//'admin_promotion',
        //'admin_master',
        'tickets',

	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
	'nuSoap' => array(
            'class' => 'ext.NuSoap' // name your class NuSoap.php
        ),
        'nuSoapnew' => array(
            'class' => 'ext.NuSoapnew' // name your class NuSoapnew.php
        ),
        'nuSoapSAtesting' => array(
            'class' => 'ext.NuSoapSAtesting' // name your class NuSoapSAtesting.php
        ),
	'cache'=>array(
	    'class'=>'system.caching.CDbCache'
	),
	'mail' => array(
                'class' => 'ext.yii-mail.YiiMail',
                'transportType'=>'smtp',
                'transportOptions'=>array(
                        'host'=>'<hostanme>',
                        'username'=>'',
                        'password'=>'',
                        'port'=>'25',
                ),
                'viewPath' => 'application.views.mail',
        ),
         'geoip' => array(
          'class' => 'application.extensions.geoip.CGeoIP',
          // specify filename location for the corresponding database
          //'filename' => 'C:\path\to\GeoIP\GeoLiteCity.dat',
	  //'filename' => "/home/indiamart/public_html/$folder_name/protected/extensions/geoip/GeoLiteCity.dat",
          // Choose MEMORY_CACHE or STANDARD mode
          'mode' => 'STANDARD',
	),
//////////////////////////////////////////////////////
'ePdf' => array(
        'class'         => 'ext.yii-pdf.EYiiPdf',
        'params'        => array(
            'mpdf' => array(
                        'librarySourcePath' => 'application.extensions.yii-pdf.MPDF57.*',
                        'constants' => array(
                            '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                        ),
                        'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                    ),

            'HTML2PDF' => array(
                'librarySourcePath' => 'application.vendors.html2pdf.*',
                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
                'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                    'orientation' => 'P', // landscape or portrait orientation
                    'format'      => 'A4', // format A4, A5, ...
                    'language'    => 'en', // language: fr, en, it ...
                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
                )
            )
        ),
    ),

		'postgress_devapproval'=>array(
			// 'class'=>'CDbConnection',
			// 'emulatePrepare' => true,
			// 'connectionString' => '-;port=5432;dbname=mesh_glusr',
			// 'charset'=>'UTF8',
			// 'persistent' => true,
			// 'autoConnect' => false,
			'class'=>'CDbConnection',
			'emulatePrepare' => true,
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=gladmin',
            'username'=>'postgres',
            'password'=>'root',
			'charset'=>'UTF8',
			'persistent' => true,
			'autoConnect' => false,
		),
		'postgress_approval'=>array(
			'class'=>'CDbConnection',
			'emulatePrepare' => true,
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=approvalpg',
            'username'=>'postgres',
            'password'=>'root',
			'charset'=>'UTF8',
			'persistent' => true,
			'autoConnect' => false,
		),

        'postgress_web77v'=>array(
			'class'=>'CDbConnection',
			'emulatePrepare' => true,
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=gladmin',
            'username'=>'postgres',
            'password'=>'root',
			'charset'=>'UTF8',
			'persistent' => true,
			'autoConnect' => false,
		),

        'postgress_web68v'=>array(
			'class'=>'CDbConnection',
			'emulatePrepare' => true,
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=imbuyreq',
            'username'=>'postgres',
            'password'=>'root',
			'charset'=>'UTF8',
			'persistent' => true,
			'autoConnect' => false,
		),

 		'errorHandler'=>array(
 			// use 'site/error' action to display errors
 			'errorAction'=>'site/error',
 		),
//		    'errorHandler'=>array(
//        'errorAction' => YII_DEBUG ? null : 'site/error',
//    ),
		'curl' => array(
            'class' => 'ext.Curl',
            'options' => array(),
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages

// 				array(
// 					'class'=>'CWebLogRoute',
// 				),
//
//                             array(
//                                         'class'=>'CWebLogRoute',
//                                         'categories'=>'system.db.*',
//                                        'except'=>'system.db.ar.*', // shows all db level logs but nothing in the ar category\r\r
//                                     ),

                                // uncomment the following to show log messages on web pages\r

//                                array(
//                                        'class'=>'CWebLogRoute',
//                               ),
//
			),
		),
	),


	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'gladmin-team@indiamart.com',
                'empID' => 1,
            
	),

);
