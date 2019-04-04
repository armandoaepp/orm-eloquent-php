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
define('ROOT', dirname(__DIR__));

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
* Directory and path to the Models directory.
*/
define('MODELS_DIR', 'Models');

define('MODELS', APP . DS . MODELS_DIR . DS);

/**
* Directory and path to the Controllers directory.
*/
define('CONTROLLERS_DIR', 'Controllers');

define('CONTROLLERS', APP . DS . CONTROLLERS_DIR . DS);


/**
* Directory and path to the Api directory.
*/
define('API_DIR', 'api');

define('API', APP . DS . API_DIR . DS);

/**
* Directory and path to the Api directory.
*/
define('HELPERS_DIR', 'Helpers');

define('HELPERS', APP . DS . API_DIR . DS);


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
define('PATH_IMAGES', ROOT . DS . IMAGES_DIR .DS );




# path/api
/* 	define('ROOT_PATH', __DIR__);
	define('ROOT_PATH', __DIR__);

	# PATH[../FOLDER_NAME]
	define('IMAGES_FOLDER', 'img_admin');
	define('IMAGES_PATH', ROOT_PATH.'/../'.IMAGES_FOLDER); */