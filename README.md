phpdevserver 0.3.2
==================

PHP Dev Server 集成了 Apache 2.4 , PHP 5.5.X/5.6.X/7.0.X , phpMyAdmin , win-Bash , 提供開發 PHP 所需的環境

PHP 本身會設定為 FASTCGI 的方式運作穩定性高。這個套件目前支援以下功能

- PHP 版本可以很簡單切換
- 所有集成的套件皆沒有重新編譯過，保證純淨
- 沒有安裝檔，可以放到任何目錄使用然後執行一次 auto-config.bat 就可以完成所有設定
- Xdebug enabled ， 預設支援 Netbeans IDE
- zend-opcache enabled in Apache mode , disabled in CLI mode
- PHP 在 apache mode 和 cli mode 有切開不同的 module 載入
- php\_imagick 模組及轉檔命令檔(可執行 %MAGICK\_HOME%\convert.exe)
- PHP 7.0 目前狀況如下
  - php_mysql 正式被移除了，所以不會支援 mysql function，僅能使用 mysqli or PDO
- 只要找的到的官方 pecl dll 都可以自己加入。 



本套件沒有包進 MySQL，一方面是難包，一方面 MySQL 或 MariaDB 自己下載來安裝就很簡單了，而且更可彈性規劃資料目錄及使用特殊功能

## 環境需求 ##

- Windows 7 64bit 以上，如果有加入 Windows AD Server 應該是不能用
- [Microsoft Visual C++ 2008 Redistributable(x64)](https://www.microsoft.com/zh-tw/download/details.aspx?id=2092) : 系統若內建則不需要
- [Microsoft Visual C++ 2012 Redistributable(x64)](https://www.microsoft.com/zh-TW/download/details.aspx?id=30679) : 系統若內建則不需要
- [Microsoft Visual C++ 2015 Redistributable(x64)](https://www.microsoft.com/en-us/download/details.aspx?id=48145) : 系統若內建則不需要

## 安裝 ##

- 將 phpdevserver 放到任何路徑，例如 C:\phpdevserver
- 執行 auto-config.bat 會自動設定好所有參數
- 請注意 : auto-config.bat 會修改系統變數 PATH 及 PHP\_INI\_SCAN\_DIR，並且會將 Apache 註冊為 Service
- 安裝完成後可以發現 Windows 右下角可以找到 ApacheMonitor 看看是否有變綠色代表 Apache 有成功運作
- 預設的 URL : http://localhost
- phpMyAdmin URL : http://localhost/phpmyadmin/

## 升級 ##

請依照以下步驟升級

- 先不要用 git 或覆蓋目錄的方式取代 phpdevserver
- 停止 Apache 服務
- 將 ApacheMonitor 退出
- 現在可以用 git 更新整個 phpdevserver 或直接下載回來取代
- 重新執行 auto-config.bat 就會自動升級並設定
- 重啟 Apache Service


## 切換 PHP 版本 ##

在 phpdevserver/bin 下有以下批次檔，可以用來切換 php 版本，也會一併修改 Apache 設定

- switch-php55.bat
- switch-php56.bat
- switch-php70.bat

當切換成功後，必須重啟 Apache 使之生效，如果要讓 CLI 模式也生效，必須重新打開 DOS Console ，然後執行以下命令看看 PHP 版本有沒有切換成功

    php -v



## 反安裝 ##

- 先不要刪除 phpdevserver 目錄
- 先反註冊 Apache24 service , 以系統管理員執行 httpd -k uninstall
- 修改系統變數 PATH ，將 %PHPDEVSERVER_PATH% 拿掉
- 移除系統變數 PHPDEVSERVER_PATH
- 移除系統變數 PHPDEVSERVER\_PHP\_VERSION
- 移除系統變數 PHP\_INI\_SCAN_DIR
- 移除系統變數 MAGICK\_HOME
- 移除 ApacheMonitor 連結於 StartUP(以 Win10 為例可能會在 C:\ProgramData\Microsoft\Windows\Start Menu\Programs\StartUp[啟動])
- 現在可以刪除 phpdevserver 目錄了


## 特別目錄說明 ##

- phpdevserver/Apache24/conf.d : php fcgid phpmyadmin 等設定都放這，建議 virtual host 或 alias 設定寫設定檔於此
- phpdevserver/phpXX/conf.apache.d : PHP 在 apache 運作會載入的模組設定都放在這
- phpdevserver/phpXX/conf.cli.d : PHP 在 CLI 模式載入的模組設定都放在

## PHP 預設已開啟功能 ##

- 模組設定區分 CLI 和 Apache 模式，分別於php路徑中 conf.cli.d 及 conf.apache.d 設定
- php.ini 預設以 php.ini-development 為主打開所有錯誤訊息方便偵錯
- 預設時區 date.timezone = UTF ，請參考 05-timezone.ini
- opcache : 64MB share memory enabled in apache mode , disabled in CLI mode
- bz2
- curl
- gd2
- imagick
- mysql + mysqli (注意 : PHP7.0 正式移除 mysql extension)
- mbstring
- openssl
- pdo_mysql + pdo_sqlite
- sockets
- xdebug
- 其他模組請參見 phpXX/ext 下的 dll，可自行新增 ini 於 conf.cli.d 或 conf.apache.d

若要修改任何模組載入，請盡量不要修改 php.ini，建議自行新增或修改 ini 於 PHPXX 中的 conf.apache.d 及 conf.cli.d

## 集成套件來源說明 ##

- Apache 2.4.18 64bit : From [www.apachelounge.com](http://www.apachelounge.com/download/)
- mod_fcgid-2.3.9-win64-V14 : From [www.apachelounge.com](http://www.apachelounge.com/download/)
- PHP 5.6.16 64bit : From [windows.php.net](http://windows.php.net/download/)
- PHP 5.5.30 64bit : From [windows.php.net](http://windows.php.net/download/)
- PHP 7.0.1 64bit : From [windows.php.net](http://windows.php.net/download/)
- win-bash 1.1 : From [win-bash.sourceforge.net](http://win-bash.sourceforge.net/)
- phpMyAdmin 4.5.3.1 : From [www.phpmyadmin.net](https://www.phpmyadmin.net/)
- Xdebug 2.4.0 RC3 : From [xdebug.org](http://xdebug.org/)
- imagick 3.4.0 RC3 : From [PECL](http://windows.php.net/downloads/pecl/releases/imagick/)
- composer : From [getcomposer.org](https://getcomposer.org )
