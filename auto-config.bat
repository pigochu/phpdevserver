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
CD %WORKING_DIRECTORY%
REM ECHO FULL PATH %WORKING_DIRECTORY%



REM SET WORKING_DIRECTORY=%WORKING_DIRECTORY:\=/%
%WORKING_DIRECTORY%\php56\php bin\scripts\auto-config.php

REM IF "%PHPDEVSERVER_PHP_VERSION%" == "" (
REM    SET PHPDEVSERVER_PHP_VERSION=php56
REM )

REM SET PHP_HOME=%WORKING_DIRECTORY%%PHPDEVSERVER%\php
REM SET BASH_HOME=%WORKING_DIRECTORY%bash
REM SET APACHE_BIN=%WORKING_DIRECTORY%Apache24\bin
REM SET PHP_INI_SCAN_DIR=%WORKING_DIRECTORY%%PHPDEVSERVER%\conf.cli.d

REM ECHO Register System Variable ...
REM setx /M PHPDEVSERVER_PHP_VERSION %PHPDEVSERVER_PHP_VERSION%
REM setx /M PHPDEVSERVER_PATH %PHP_HOME%;%BASH_HOME%;%APACHE_BIN%"
REM pause
REM REM Search PATH if not exist any setting , reset it !
REM if "%PATH%"=="%PATH:PHPDEVSERVER_PATH%" (
REM     SET PATH=%PATH%;^%PHPDEVSERVER_PATH^%
REM    setx /M PATH "%PATH%"
REM )


ECHO Register Apache24 as Service
%WORKING_DIRECTORY%\Apache24\bin\httpd -k install



ECHO "Enjoy it."
pause
@echo on