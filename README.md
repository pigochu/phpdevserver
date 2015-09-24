phpdevserver
============

PHP Dev Server 集成了 Apache 2.4 , PHP 5.6.X , phpMyAdmin , win-Bash , 提供開發 PHP 所需的環境

PHP 本身會設定為 FASTCGI 的方式運作穩定性高。這個套件目前支援以下功能

- 所有集成的套件皆沒有重新編譯過，保證純淨
- 沒有安裝檔，可以放到任何目錄使用然後執行一次 auto-config.bat 就可以完成所有設定
- PHP 運作於 FASTCGI 模式，穩定
- Xdebug enabled ， 預設支援 Netbeans IDE
- zend-opcache enabled in Apache mode , disabled in CLI mode
- PHP 在 apache mode 和 cli mode 有切開不同的 module 載入

本套件沒有包進 MySQL，一方面是難包，一方面 MySQL 或 MariaDB 自己下載來安裝就可以了，而且更可彈性規劃資料目錄

## 環境需求 ##

- Windows 7 64bit 以上，如果有加入 Windows AD Server 應該是不能用
- [Microsoft Visual C++ 2008 Redistributable(x64)](http://https://www.microsoft.com/zh-tw/download/details.aspx?id=2092) : 非必要，系統搞不好內建
- [Microsoft Visual C++ 2012 Redistributable(x64)](https://www.microsoft.com/zh-TW/download/details.aspx?id=30679) : 非必要，系統搞不好內建
- [Microsoft Visual C++ 2015 Redistributable(x64)](https://www.microsoft.com/en-us/download/details.aspx?id=48145) : 非必要，系統搞不好內建

## 安裝 ##

- 將 phpdevserver 放到任何路徑，例如 C:\phpdevserver
- 必須以**系統管理員身分**執行 auto-config.bat 會自動設定好所有參數
- 請注意 : auto-config.bat 會修改系統變數 PATH 及 PHP_INI_SCAN_DIR，並且會將 Apache 註冊為 Service


## 反安裝 ##

- 先不要刪除 phpdevserver 目錄
- 先反註冊 Apache24 service , 以系統管理員執行 httpd -k uninstall
- 移除系統變數 PATH 中關於 phpdevserver 的路徑
- 移除系統變數 PHP_INI_SCAN_DIR
- 現在可以刪除 phpdevserver 目錄了

## 特別目錄說明 ##

- phpdevserver/Apache24/conf.d : php fcgid phpmyadmin 等設定都放這
- phpdevserver/php/conf.apache.d : PHP 在 apache 運作會載入的模組設定都放在這
- phpdevserver/php/conf.cli.d : PHP 在 CLI 模式載入的模組設定都放在

## PHP 已開啟功能 ##

- 模組設定區分 CLI 和 Apache 模式，分別於php路徑中 conf.cli.d 及 conf.apache.d 設定
- php.ini 預設以 php.ini-development 為主打開所有錯誤訊息方便偵錯
- php.ini 預設時區 date.timezone = UTF
- opcache : 64MB enabled in apache , disabled in cli
- bz2
- curl
- mysql + mysqli
- mbstring
- openssl
- pdo_mysql + pdo_sqlite

建議若要修改任何模組載入，請不要修改 php.ini，日後升級時會蓋掉 php.ini

## 集成套件來源說明 ##

- Apache 2.4.16 64bit : From [www.apachelounge.com](http://www.apachelounge.com/download/)
- mod_fcgid-2.3.9-win64-V14 : From [www.apachelounge.com](http://www.apachelounge.com/download/)
- PHP 5.6.13 64bit : From [windows.php.net](http://windows.php.net/download/)
- win-bash 1.1 : From [win-bash.sourceforge.net](http://win-bash.sourceforge.net/)
- phpMyAdmin 4.4.15 : From [www.phpmyadmin.net](https://www.phpmyadmin.net/)
- Xdebug 2.3.3 : From [xdebug.org](http://xdebug.org/)
