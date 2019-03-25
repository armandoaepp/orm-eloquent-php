<?php

/**
 * Use the DS to separate the directories in other defines
 */
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

/**
* These defines should only be edited if you have cake installed in
* a directory layout other than the way it is distributed.
* When using custom settings be sure to use the DS and do not add a trailing DS.
*/

/**
* The full path to the directory which holds "src", WITHOUT a trailing DS.
*/
define('ROOT', dirname(dirname(__DIR__)));

/**
* The actual directory name for the application directory. Normally
* named 'app'.
*/
define('APP_DIR', 'app');

/**
* Path to the application's directory.
*/
define('APP', ROOT . DS . APP_DIR . DS);

/**
* Path to the config directory.
*/
define('CONFIG', ROOT . DS . 'config' . DS);

/**
* File path to the webroot directory.
*/
define('ADMIN', ROOT . DS . 'admin' . DS);

/**
* The actual directory name for images directory. Normally
* named 'app'.
*/
define('IMAGES_DIR',   'images');

/**
* Path to the application's directory.
*/
// define('IMAGES', ROOT . DS . IMAGES_DIR . DS);
define('IMAGES', ROOT . DS . IMAGES_DIR .DS );




# path/api
/* 	define('ROOT_PATH', __DIR__);
	define('ROOT_PATH', __DIR__);

	# PATH[../FOLDER_NAME]
	define('IMAGES_FOLDER', 'img_admin');
	define('IMAGES_PATH', ROOT_PATH.'/../'.IMAGES_FOLDER); */