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
