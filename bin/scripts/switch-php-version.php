<?php
require(dirname(__FILE__) . "/common.php");

if(!isset($_SERVER['argv'][1])) {
    exit;
}

$version = $_SERVER['argv'][1];

$PHPDEVSERVER_PATH = dirname(dirname(dirname(__FILE__)));


putenv("PHPDEVSERVER_PHP_VERSION={$version}");
system("setx /M PHPDEVSERVER_PHP_VERSION " .getenv("PHPDEVSERVER_PHP_VERSION"));

putenv("PHPDEVSERVER_PATH=" ."{$PHPDEVSERVER_PATH}\\".getenv("PHPDEVSERVER_PHP_VERSION") . ";{$PHPDEVSERVER_PATH}\\bash"  .";{$PHPDEVSERVER_PATH}\\Apache24\\bin" . ";{$PHPDEVSERVER_PATH}\\bin");
system("setx /M PHPDEVSERVER_PATH " . getenv("PHPDEVSERVER_PATH"));

putenv("PHP_INI_SCAN_DIR={$PHPDEVSERVER_PATH}\\" . getenv("PHPDEVSERVER_PHP_VERSION") .'\conf.cli.d' );
system("setx /M PHP_INI_SCAN_DIR " .getenv("PHP_INI_SCAN_DIR"));

system("setx /M PHPDEVSERVER_PHP_VERSION " .getenv("PHPDEVSERVER_PHP_VERSION"));
// config apache
config_apache_php_module($PHPDEVSERVER_PATH , getenv("PHPDEVSERVER_PHP_VERSION"));