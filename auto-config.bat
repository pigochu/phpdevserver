@echo off
REM Auto Config
REM Author : pigochu@gmail.com


:: BatchGotAdmin
:-------------------------------------
REM  --> Check for permissions
>nul 2>&1 "%SYSTEMROOT%\system32\cacls.exe" "%SYSTEMROOT%\system32\config\system"

REM --> If error flag set, we do not have admin.
if '%errorlevel%' NEQ '0' (
    echo Requesting administrative privileges...
    goto UACPrompt
) else ( goto gotAdmin )

:UACPrompt
    echo Set UAC = CreateObject^("Shell.Application"^) > "%temp%\getadmin.vbs"
    set params = %*:"=""
    echo UAC.ShellExecute "cmd.exe", "/c %~s0 %params%", "", "runas", 1 >> "%temp%\getadmin.vbs"

    "%temp%\getadmin.vbs"
    del "%temp%\getadmin.vbs"
    exit /B

:gotAdmin
    pushd "%CD%"
    CD /D "%~dp0"
:--------------------------------------



SET WORKING_DIRECTORY=%~dp0
SET PATH=%PATH%;%WORKING_DIRECTORY%\php

CD %WORKING_DIRECTORY%

REM SET WORKING_DIRECTORY=%WORKING_DIRECTORY:\=/%
%WORKING_DIRECTORY%\php56\php bin\scripts\auto-config.php

IF "%PHPDEVSERVER_PHP_VERSION%" == "" (
    SET PHPDEVSERVER_PHP_VERSION=php56
)

SET PHP_HOME=%WORKING_DIRECTORY%\%PHPDEVSERVER%\php
SET BASH_HOME=%WORKING_DIRECTORY%\bash
SET APACHE_BIN=%WORKING_DIRECTORY%\Apache24\bin
SET PHP_INI_SCAN_DIR=%WORKING_DIRECTORY%\%PHPDEVSERVER%\conf.cli.d

ECHO Register System Variable ...
setx /M PHPDEVSERVER_PHP_VERSION=%PHPDEVSERVER%
setx /M PHPDEVSERVER_PATH="^%PHP_HOME^%;^%BASH_HOME^%;^%APACHE_BIN^%"

REM Search PATH if not exist any setting , reset it !
if "%PATH%"=="%PATH:PHPDEVSERVER_PATH=%" (
    SET PATH=%PATH%;^%PHPDEVSERVER_PATH^%
    setx /M PATH "%PATH%"
)

ECHO Register Apache24 as Service
%APACHE_BIN%\httpd -k install



ECHO "Enjoy it."
pause
@echo on