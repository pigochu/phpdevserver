<?php
require(dirname(__FILE__) . "/common.php");
$PHPDEVSERVER_PATH = dirname(dirname(dirname(__FILE__)));

echo "** Auto Config phpdevserver **" . PHP_EOL . PHP_EOL;
// copy all template config file
echo "Configuring PHP default settings ... ";
// copy php55 php.ini
if(false === file_exists("{$PHPDEVSERVER_PATH}/php55/php.ini")) {
    copy("{$PHPDEVSERVER_PATH}/php55/php.ini-development" ,"{$PHPDEVSERVER_PATH}/php55/php.ini" );
}
// copy php55 config file
copyfolder("{$PHPDEVSERVER_PATH}/bin/scripts/templates/php55" , "{$PHPDEVSERVER_PATH}/php55");

// copy php56 php.ini
if(false === file_exists("{$PHPDEVSERVER_PATH}/php56/php.ini")) {
    copy("{$PHPDEVSERVER_PATH}/php56/php.ini-development" ,"{$PHPDEVSERVER_PATH}/php56/php.ini" );
}
// copy php56 config file
// copy php55 config file
copyfolder("{$PHPDEVSERVER_PATH}/bin/scripts/templates/php56" , "{$PHPDEVSERVER_PATH}/php56");

// replace zend-opecache path
echo "Configuring PHP zend-opcache module ... ";
$ini_file = array(
	"{$PHPDEVSERVER_PATH}/php55/conf.apache.d/10-opcache.ini"    => "{$PHPDEVSERVER_PATH}/php55/ext/php_opcache.dll" ,
	"{$PHPDEVSERVER_PATH}/php56/conf.apache.d/10-opcache.ini"    => "{$PHPDEVSERVER_PATH}/php56/ext/php_opcache.dll" ,
	"{$PHPDEVSERVER_PATH}/php56/conf.cli.d/11-xdebug.ini"       => "{$PHPDEVSERVER_PATH}/php56/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_PATH}/php56/conf.apache.d/11-xdebug.ini"    => "{$PHPDEVSERVER_PATH}/php56/ext/php_xdebug.dll" ,
);
        
foreach($ini_file as $k => $v) {
    preg_replace_file(
	$k ,
	'/zend_extension.*=.*/i',
	"zend_extension = " . realpath($v)
    );
}
echo "OK" . PHP_EOL;

// replace xdebug path
echo "Configuring PHP xdebug module ... ";
$ini_file = array(
	"{$PHPDEVSERVER_PATH}/php55/conf.cli.d/11-xdebug.ini"       => "{$PHPDEVSERVER_PATH}/php55/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_PATH}/php55/conf.apache.d/11-xdebug.ini"    => "{$PHPDEVSERVER_PATH}/php55/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_PATH}/php56/conf.cli.d/11-xdebug.ini"       => "{$PHPDEVSERVER_PATH}/php56/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_PATH}/php56/conf.apache.d/11-xdebug.ini"    => "{$PHPDEVSERVER_PATH}/php56/ext/php_xdebug.dll" ,
);
foreach($ini_file as $k => $v) {
	preg_replace_file(
		$k ,
		'/zend_extension.*=.*/i',
		"zend_extension = " . realpath($v)
	);
}
echo "OK" . PHP_EOL;

// copy phpMyAdmin config.sample.php to config.php
echo "Configuring phpMyAdmin ... ";
$conf_file = "{$PHPDEVSERVER_PATH}/phpmyadmin/config.inc.php";
$sample_file = "{$PHPDEVSERVER_PATH}/phpmyadmin/config.sample.inc.php";
if(!file_exists($conf_file)) {
	copy($sample_file , $conf_file);
	preg_replace_file(
		$conf_file ,
		"/\\\$cfg\\[\\'blowfish_secret\\'\\].*=.*/i",
		"\$cfg['blowfish_secret'] = '" .md5(time()). "';"
	);
}

echo "OK" . PHP_EOL;


echo "Configuring Apache24 ... ";
// copy Apache24 config file
copyfolder("{$PHPDEVSERVER_PATH}/bin/scripts/templates/Apache24" , "{$PHPDEVSERVER_PATH}/Apache24");
$conf_file = "{$PHPDEVSERVER_PATH}/Apache24/conf/httpd.conf";
if(file_exists($conf_file)) {
	preg_replace_file(
		$conf_file ,
		"/%__PHPDEVSERVER__%/i",
		cpath($PHPDEVSERVER_PATH)
	);
} 
echo "OK" . PHP_EOL;

// Replace all php fcgid setting
echo "Configuring PHP as Apache fcgid module ... ";
$php_version = @getenv("PHPDEVSERVER_PHP_VERSION");
if($php_version === "") {
    $php_version = "php56";
}
config_apache_php_module($PHPDEVSERVER_PATH , $php_version);

echo "OK" . PHP_EOL;


echo "Configuring phpMyAdmin as Apache alias path ... ";
$conf_file = "{$PHPDEVSERVER_PATH}/Apache24/conf.d/51-phpmyadmin.conf";

preg_replace_file(
	$conf_file ,
	"/Alias.*\\/phpmyadmin.*/",
	"Alias /phpmyadmin " . "\"" . cpath("{$PHPDEVSERVER_PATH}/phpmyadmin") . "\""
);


preg_replace_file(
	$conf_file ,
	"/<Directory \\\".*\\\">/i",
	"<Directory \"" . cpath("{$PHPDEVSERVER_PATH}/phpmyadmin") . "\">"
);
echo "OK" . PHP_EOL;





// SET Env: PHPDEVSERVER_PHP_VERSION
if(!getenv("PHPDEVSERVER_PHP_VERSION")) {
    putenv("PHPDEVSERVER_PHP_VERSION=php56");
}

$need_modify_path = false;
if(getenv("PHPDEVSERVER_PATH") === false) {
    $need_modify_path = true;
}

putenv("PHPDEVSERVER_PATH=" ."{$PHPDEVSERVER_PATH}\\".getenv("PHPDEVSERVER_PHP_VERSION") . ";{$PHPDEVSERVER_PATH}\\bash"  .";{$PHPDEVSERVER_PATH}\\Apache24\\bin" . ";{$PHPDEVSERVER_PATH}\\bin");
putenv("PHP_INI_SCAN_DIR={$PHPDEVSERVER_PATH}\\" . getenv("PHPDEVSERVER_PHP_VERSION") .'\conf.cli.d' );


system("setx /M PHPDEVSERVER_PHP_VERSION " .getenv("PHPDEVSERVER_PHP_VERSION"));
system("setx /M PHPDEVSERVER_PATH " . getenv("PHPDEVSERVER_PATH"));
system("setx /M PHP_INI_SCAN_DIR " .getenv("PHP_INI_SCAN_DIR"));

if($need_modify_path === true) {
    putenv("PATH=" .getenv("PATH") . ";" . "%PHPDEVSERVER_PATH%");
    system("setx /M PATH \"%PATH%\"");
}

echo "Register System Variable ... OK" . PHP_EOL;