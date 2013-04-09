<?php
/**
 * Test bootstrap file.
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

$basePath = dirname(__FILE__);

/** @todo change the following paths if necessary */
require($basePath . '/../../../../../frameworks/yii/framework/yiit.php');

// make sure non existing PHPUnit classes do not break with Yii autoloader
Yii::$enableIncludePath = false;
Yii::createWebApplication(
	array(
		'basePath' => $basePath . '/..',
		'extensionPath' => $basePath . '/../..',
		'import' => array(
			'application.tests.models.*',
			'application.ETrashBinBehavior',
		),
		'components' => array(
			'fixture' => array(
				'class' => 'system.test.CDbFixtureManager',
			),
			'db' => array(
				'connectionString' => 'sqlite:' . $basePath . '/data/testdrive.db',
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
			),
		),
	)
);