<?php
require(dirname(__FILE__) . "/common.php");
$PHPDEVSERVER_HOME = dirname(dirname(dirname(__FILE__)));

echo "** Auto Config phpdevserver **" . PHP_EOL . PHP_EOL;
// copy all template config file
echo "Configuring PHP default settings ... ";
// copy php55 php.ini
if(false === file_exists("{$PHPDEVSERVER_HOME}/php55/php.ini")) {
    copy("{$PHPDEVSERVER_HOME}/php55/php.ini-development" ,"{$PHPDEVSERVER_HOME}/php55/php.ini" );
}
// copy php55 config file
copyfolder("{$PHPDEVSERVER_HOME}/bin/scripts/templates/php55" , "{$PHPDEVSERVER_HOME}/php55");

// copy php56 php.ini
if(false === file_exists("{$PHPDEVSERVER_HOME}/php56/php.ini")) {
    copy("{$PHPDEVSERVER_HOME}/php56/php.ini-development" ,"{$PHPDEVSERVER_HOME}/php56/php.ini" );
}
// copy php56 config file
// copy php55 config file
copyfolder("{$PHPDEVSERVER_HOME}/bin/scripts/templates/php56" , "{$PHPDEVSERVER_HOME}/php56");

// replace zend-opecache path
echo "Configuring PHP zend-opcache module ... ";
$ini_file = array(
	"{$PHPDEVSERVER_HOME}/php55/conf.apache.d/10-opcache.ini"    => "{$PHPDEVSERVER_HOME}/php55/ext/php_opcache.dll" ,
	"{$PHPDEVSERVER_HOME}/php56/conf.apache.d/10-opcache.ini"    => "{$PHPDEVSERVER_HOME}/php56/ext/php_opcache.dll" ,
	"{$PHPDEVSERVER_HOME}/php56/conf.cli.d/11-xdebug.ini"       => "{$PHPDEVSERVER_HOME}/php56/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_HOME}/php56/conf.apache.d/11-xdebug.ini"    => "{$PHPDEVSERVER_HOME}/php56/ext/php_xdebug.dll" ,
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
	"{$PHPDEVSERVER_HOME}/php55/conf.cli.d/11-xdebug.ini"       => "{$PHPDEVSERVER_HOME}/php55/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_HOME}/php55/conf.apache.d/11-xdebug.ini"    => "{$PHPDEVSERVER_HOME}/php55/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_HOME}/php56/conf.cli.d/11-xdebug.ini"       => "{$PHPDEVSERVER_HOME}/php56/ext/php_xdebug.dll" ,
	"{$PHPDEVSERVER_HOME}/php56/conf.apache.d/11-xdebug.ini"    => "{$PHPDEVSERVER_HOME}/php56/ext/php_xdebug.dll" ,
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
$conf_file = "{$PHPDEVSERVER_HOME}/phpmyadmin/config.inc.php";
$sample_file = "{$PHPDEVSERVER_HOME}/phpmyadmin/config.sample.inc.php";
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
copyfolder("{$PHPDEVSERVER_HOME}/bin/scripts/templates/Apache24" , "{$PHPDEVSERVER_HOME}/Apache24");
$conf_file = "{$PHPDEVSERVER_HOME}/Apache24/conf/httpd.conf";
if(file_exists($conf_file)) {
	preg_replace_file(
		$conf_file ,
		"/%__PHPDEVSERVER__%/i",
		cpath($PHPDEVSERVER_HOME)
	);
} 
echo "OK" . PHP_EOL;

// Replace all php fcgid setting
echo "Configuring PHP as Apache fcgid module ... ";
$php_version = @getenv("PHPDEVSERVER_PHP_VERSION");
if(!$php_version) {
    $php_version = "php56";
}
config_apache_php_module($PHPDEVSERVER_HOME , $php_version);

echo "OK" . PHP_EOL;


echo "Configuring phpMyAdmin as Apache alias path ... ";
$conf_file = "{$PHPDEVSERVER_HOME}/Apache24/conf.d/51-phpmyadmin.conf";

preg_replace_file(
	$conf_file ,
	"/Alias.*\\/phpmyadmin.*/",
	"Alias /phpmyadmin " . "\"" . cpath("{$PHPDEVSERVER_HOME}/phpmyadmin") . "\""
);


preg_replace_file(
	$conf_file ,
	"/<Directory \\\".*\\\">/i",
	"<Directory \"" . cpath("{$PHPDEVSERVER_HOME}/phpmyadmin") . "\">"
);
echo "OK" . PHP_EOL;



$registry = new Registry();
$ORIG_PATH = $registry->read('HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\Path');
if(!$ORIG_PATH) {
    $ORIG_PATH = getenv("PATH");
    if(!$ORIG_PATH) {
        $ORIG_PATH = "";
    }
}

// CHECK IF NEED Modify PATH
$paths = explode(";" , $ORIG_PATH);
$need_modify_path = true;
foreach($paths as $p) {
    if(strpos($p , '%PHPDEVSERVER_PATH%') !== false) {
        $need_modify_path = false;
        break;
    }
}




// SET Env: PHPDEVSERVER_PHP_VERSION
if(!getenv("PHPDEVSERVER_PHP_VERSION")) {
    putenv("PHPDEVSERVER_PHP_VERSION=php56");
}


putenv(
    "PHPDEVSERVER_PATH=" ."{$PHPDEVSERVER_HOME}\\".getenv("PHPDEVSERVER_PHP_VERSION")
    . ";{$PHPDEVSERVER_HOME}\\bash"
    . ";{$PHPDEVSERVER_HOME}\\Apache24\\bin"
    . ";{$PHPDEVSERVER_HOME}\\bin"
    . ";{$PHPDEVSERVER_HOME}\\ImageMagick"
);
putenv("PHP_INI_SCAN_DIR={$PHPDEVSERVER_HOME}\\" . getenv("PHPDEVSERVER_PHP_VERSION") .'\conf.cli.d' );
putenv("MAGICK_HOME={$PHPDEVSERVER_HOME}\\ImageMagick");

// $registry->write('HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\PHPDEVSERVER_PHP_VERSION' , getenv("PHPDEVSERVER_PHP_VERSION") , "REG_SZ");
// $registry->write('HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\PHPDEVSERVER_PATH' , getenv("PHPDEVSERVER_PATH") , "REG_EXPAND_SZ");
// $registry->write('HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\PHP_INI_SCAN_DIR' , getenv("PHP_INI_SCAN_DIR") , "REG_SZ");
// $registry->write('HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\MAGICK_HOME' , getenv("MAGICK_HOME") , "REG_SZ");
system("setx /M PHPDEVSERVER_PHP_VERSION " .getenv("PHPDEVSERVER_PHP_VERSION"));
system("setx /M PHPDEVSERVER_PATH \"" . getenv("PHPDEVSERVER_PATH")) . "\"";
system("setx /M PHP_INI_SCAN_DIR \"" .getenv("PHP_INI_SCAN_DIR")) . "\"";
system("setx /M MAGICK_HOME \"" .getenv("MAGICK_HOME")) ."\"";

if($need_modify_path === true) {
    putenv("PATH=" .getenv("PATH") . ";" . "%PHPDEVSERVER_PATH%");
    system( escapeshellcmd ( "setx /M PATH \"{$ORIG_PATH};%PHPDEVSERVER_PATH%\"") );
    // $registry->write('HKEY_LOCAL_MACHINE\SYSTEM\CurrentControlSet\Control\Session Manager\Environment\Path' , $ORIG_PATH.";%PHPDEVSERVER_PATH%" , "REG_EXPAND_SZ");
}

echo "Register System Variable ... OK" . PHP_EOL;

$startup_path = getenv("ProgramData") . "\\Microsoft\\Windows\\Start Menu\\Programs\\StartUp" ;
$apachemon_path = "{$PHPDEVSERVER_HOME}\\Apache24\\bin\\ApacheMonitor.exe";
if(file_exists($startup_path)) {
    // Make ApacheMonitor Link to StartUp
    system("MKLINK \"{$startup_path}\\ApacheMonitor\"  \"$apachemon_path\" ");
    // echo "MKLINK \"$apachemon_path\"  \"{$startup_path}\\ApacheMonitor\"";
    echo "Make ApacheMonitor link to Boot StartUp ... OK" . PHP_EOL;
}

