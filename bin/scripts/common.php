<?php

/**
 * Replace content in file
 * @param string $file
 * @param string $pattern
 * @param string $replacement
 * @return boolean
 */
function preg_replace_file ($file , $pattern , $replacement ) {
	$content = @file_get_contents($file);
	if(false === $content) {
		return false;
	}
	$content = preg_replace($pattern, $replacement, $content);
	file_put_contents($file , $content);
	return true;
}

/**
 * Convert path : all '\' will convert to '/'
 * @param string $path
 * @return bool
 */
function cpath($path) {
	return str_replace( "\\" , "/" , realpath($path));
}

/**
 * Copy all files to folder , it will ignore when file is existed
 * @param string $src
 * @param string $dest
 */
function copyfolder($src , $dst) {
    $dir = opendir($src);
    @mkdir($dst); 
    while(false !== ( $file = readdir($dir)) ) { 
        if (( $file != '.' ) && ( $file != '..' )) { 
            if ( is_dir($src . '/' . $file) ) { 
                copyfolder($src . '/' . $file,$dst . '/' . $file); 
            } 
            else {
                if(false === file_exists($dst . '/' . $file)) {
                    copy($src . '/' . $file,$dst . '/' . $file); 
                }
            } 
        }
    } 
    closedir($dir);
}

/**
 * Command Line confirm
 * @param string $message
 * @param string $yes
 * @param string $no
 * @param boolean $ignore_case if true , ignore case check
 * @return boolean
 */
function confirm($message , $yes = 'y' , $no = 'n' , $ignore_case = true) {
    echo $message;
    flush();
    ob_flush();
    $confirmation  =  trim( fgets( STDIN ) );
    
    if(true === $ignore_case) {
        if(strtolower($confirmation) !== strtolower($yes)) {
            return false;
        }
    } else if ( $confirmation !== $yes ) {
       // The user did not say 'y'.
       return false;
    }
    return true;
}


function config_apache_php_module($PHPDEVSERVER_PATH , $php_version){
    $conf_file = "{$PHPDEVSERVER_PATH}/Apache24/conf.d/50-php.conf";
    preg_replace_file(
            $conf_file ,
            "/FcgidInitialEnv.*PHPRC.*/i",
            "FcgidInitialEnv PHPRC " . "\"" . cpath("{$PHPDEVSERVER_PATH}/{$php_version}") . "\""
    );
    preg_replace_file(
            $conf_file ,
            "/FcgidInitialEnv.*PHP_INI_SCAN_DIR.*/i",
            "FcgidInitialEnv PHP_INI_SCAN_DIR " . "\"" . cpath("{$PHPDEVSERVER_PATH}/{$php_version}/conf.apache.d") . "\""
    );
            
    preg_replace_file(
            $conf_file ,
            "/FcgidInitialEnv.*MAGICK_HOME.*/i",
            "FcgidInitialEnv MAGICK_HOME " . "\"" . cpath("{$PHPDEVSERVER_PATH}/ImageMagick") . "\""
    );

    preg_replace_file(
            $conf_file ,
            "/FcgidInitialEnv\\s+TEMP .*/i",
            "FcgidInitialEnv TEMP " . "\"" . cpath(getenv("SystemRoot") . "\Temp") . "\""
    );
    
    preg_replace_file(
            $conf_file ,
            "/FcgidInitialEnv\\s+TMP .*/i",
            "FcgidInitialEnv TMP " . "\"" . cpath(getenv("SystemRoot") . "\Temp") . "\""
    );
            
    preg_replace_file(
            $conf_file ,
            "/FcgidWrapper.*/i",
            "FcgidWrapper " . "\"" . cpath("{$PHPDEVSERVER_PATH}/{$php_version}/php-cgi.exe") . "\"" . " .php"
    );
}
