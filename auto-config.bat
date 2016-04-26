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
CD "%WORKING_DIRECTORY%"

SET ORIG_PHP_INI_SCAN_DIR=%PHP_INI_SCAN_DIR%
SET PHP_INI_SCAN_DIR=%WORKING_DIRECTORY%\php56\conf.cli.d
"%WORKING_DIRECTORY%\php56\php" -c "%WORKING_DIRECTORY%\php56"  -dextension_dir=ext -dextension=php_com_dotnet.dll "%WORKING_DIRECTORY%\bin\scripts\auto-config.php"
SET PHP_INI_SCAN_DIR=%ORIG_PHP_INI_SCAN_DIR%

ECHO UnRegister Apache24 as Service
%WORKING_DIRECTORY%\Apache24\bin\httpd -k uninstall

ECHO Register Apache24 as Service
%WORKING_DIRECTORY%\Apache24\bin\httpd -k install

ECHO Auto Config is done.

ECHO You can test URL http://localhost
ECHO phpMyadmin URL is http://localhost/phpmyadmin/

ECHO "Enjoy it."
pause
@echo on