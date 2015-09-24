<?php

$WORKING_DIRECTORY = dirname(__FILE__);

function preg_replace_file ($file , $pattern , $replacement ) {
	
	$content = @file_get_contents($file);
	if(false === $content) {
		return false;
	}
	$content = preg_replace($pattern, $replacement, $content);
	file_put_contents($file , $content);
	return true;
}

function cpath($path) {
	return str_replace( "\\" , "/" , realpath($path));
}


echo "** Auto Config phpdevserver **" . PHP_EOL . PHP_EOL;


// replace zend-opecache path
echo "Configuring PHP zend-opcache module ... ";
$ini_file = "{$WORKING_DIRECTORY}/php/conf.apache.d/10-opcache.ini";
preg_replace_file(
	$ini_file ,
	'/zend_extension.*=.*/i',
	"zend_extension = " . realpath( "{$WORKING_DIRECTORY}/php/ext/php_opcache.dll" )
);

echo "OK" . PHP_EOL;

// replace xdebug path
echo "Configuring PHP xdebug module ... ";
$ini_file = array(
	"{$WORKING_DIRECTORY}/php/conf.cli.d/11-xdebug.ini" ,
	"{$WORKING_DIRECTORY}/php/conf.apache.d/11-xdebug.ini" ,
);

foreach($ini_file as $f) {
	preg_replace_file(
		$f ,
		'/zend_extension.*=.*/i',
		"zend_extension = " . realpath( "{$WORKING_DIRECTORY}/php/ext/php_xdebug.dll" )
	);
}
echo "OK" . PHP_EOL;

// copy phpMyAdmin config.sample.php to config.php
echo "Configuring phpMyAdmin ... ";
$conf_file = "{$WORKING_DIRECTORY}/phpmyadmin/config.inc.php";
$sample_file = "{$WORKING_DIRECTORY}/phpmyadmin/config.sample.inc.php";
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
$conf_file = "{$WORKING_DIRECTORY}/Apache24/conf/httpd.conf";
$sample_file = "{$WORKING_DIRECTORY}/Apache24/conf/httpd.sample.conf";
if(!file_exists($conf_file)) {

	copy($sample_file , $conf_file);
	preg_replace_file(
		$conf_file ,
		"/%__PHPDEVSERVER__%/i",
		cpath($WORKING_DIRECTORY)
	);
}
echo "OK" . PHP_EOL;

// Replace all php fcgid setting
echo "Configuring PHP as Apache fcgid module ... ";
$conf_file = "{$WORKING_DIRECTORY}/Apache24/conf.d/55-php.conf";
preg_replace_file(
	$conf_file ,
	"/FcgidInitialEnv.*PHPRC.*/i",
	"FcgidInitialEnv PHPRC " . "\"" . cpath("{$WORKING_DIRECTORY}/php") . "\""
);
preg_replace_file(
	$conf_file ,
	"/FcgidInitialEnv.*PHP_INI_SCAN_DIR.*/i",
	"FcgidInitialEnv PHP_INI_SCAN_DIR " . "\"" . cpath("{$WORKING_DIRECTORY}/php/conf.apache.d") . "\""
);

preg_replace_file(
	$conf_file ,
	"/FcgidWrapper.*/i",
	"FcgidWrapper " . "\"" . cpath("{$WORKING_DIRECTORY}/php/php-cgi.exe") . "\"" . " .php"
);

echo "OK" . PHP_EOL;


echo "Configuring phpMyAdmin as Apache alias path ... ";
$conf_file = "{$WORKING_DIRECTORY}/Apache24/conf.d/88-phpmyadmin.conf";

preg_replace_file(
	$conf_file ,
	"/Alias.*\\/phpmyadmin.*/",
	"Alias /phpmyadmin " . "\"" . cpath("{$WORKING_DIRECTORY}/phpmyadmin") . "\""
);


preg_replace_file(
	$conf_file ,
	"/<Directory \\\".*\\\">/i",
	"<Directory \"" . cpath("{$WORKING_DIRECTORY}/phpmyadmin") . "\">"
);
echo "OK" . PHP_EOL;

echo "phpMyAdmin URL : http://localhost/phpmyadmin/" . PHP_EOL;
