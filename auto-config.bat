@echo off
REM Auto Config
REM Author : pigochu@gmail.com

SET WORKING_DIRECTORY=%~dp0
SET PATH=%PATH%;%WORKING_DIRECTORY%\php

CD %WORKING_DIRECTORY%

REM SET WORKING_DIRECTORY=%WORKING_DIRECTORY:\=/%
php auto-config.php


IF "%PHP_INI_SCAN_DIR%"=="" (

	ECHO Register System Variable : PATH

	setx /M PATH "%PATH%;%WORKING_DIRECTORY%\bash;%WORKING_DIRECTORY%\php;%WORKING_DIRECTORY%\apache24\bin"
	
	ECHO Register System Variable : PHP_INI_SCAN_DIR
	setx /M PHP_INI_SCAN_DIR "%WORKING_DIRECTORY%\php\conf.cli.d"
)

ECHO Register Apache24 as Service
cd %WORKING_DIRECTORY%\Apache24\bin
httpd -k uninstall
httpd -k install



ECHO "Enjoy it."
pause
@echo on