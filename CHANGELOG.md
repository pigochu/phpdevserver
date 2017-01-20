phpdevserver Change Log
========================

0.5.3 2017-01-20
-----------------------

- 升級 PHP56 至 5.6.30
- 升級 PHP70 至 7.0.15
- 升級 PHP71 至 7.1.1
- 升級 php-imagick 至 3.4.3 RC2


0.5.2 2017-01-09
-----------------------

- 升級 phpmyadmin 至 4.6.5.2
- 升級 composer 至 1.3.1

0.5.1 2016-12-27
-----------------------

- 升級 composer 至 1.3.0
- 升級 PHP70 至 7.0.14
- 升級 PHP56 至 5.6.29
- 升級 Apache 至 2.4.25
  


0.5.0 2016-12-05
-----------------------

- 新增可切換 PHP71 : switch-php71
- **新增 PHP 7.1.0**
- **升級時請記得要先執行 auto-config才能讓 PHP7.1 各種環境設定好**
- 升級 composer 至 1.2.3
- 升級 php-xdebug 至 2.5.0 stable


0.4.5 2016-11-30
-----------------------

- 升級 phpMyAdmin 至 4.6.5.1
- 升級 php-xdebug 至 2.5.0 RC1

0.4.4 2016-11-14
-----------------------

- 升級 PHP70 至 7.0.13
- 升級 PHP56 至 5.6.28


0.4.3 2016-11-04
-----------------------

- 升級 composer 至 1.2.2
- 升級 PHP70 至 7.0.12
- 升級 PHP56 至 5.6.27


0.4.2 2016-10-07
-----------------------

- 升級 composer 至 1.2.1
- Apache24 缺少相關設定檔導致無法執行auto-config.bat
- PHP70 的 apcu 升級至 5.1.6
- 升級 PHP70 至 7.0.11
- 升級 PHP56 至 5.6.26



0.4.1 2016-08-22
-----------------------

- Apache24 來源改為 http://www.apachehaus.com/
- Apache24 升級至 2.4.23
- 升級 composer 至 1.2.0
- 升級 PHP70 至 7.0.10
- 升級 PHP56 至 5.6.25
- 升級 PHP55 至 5.5.38
- 升級 phpmyadmin 至 4.6.4
- 升級 php-xdebug 至 2.4.1

0.4.0 2016-07-12
-----------------------

- auto-config 加入 apache service uninstall 之後再 install
- 升級 composer 至 1.1.3
- 升級 PHP55 至 5.5.37
- 升級 PHP56 至 5.6.23
- 升級 PHP70 至 7.0.8
- 升級 PHP70 的 php-apcu 至 5.1.5
- 升級 PHP55/PHP56 的 php-apcu 至 4.0.11
- 升級 php-imagick 至 3.4.3 RC1
- 升級 phpMyAdmin 至 4.6.3
- 升級 Imagick 至 6.9.3-7
- 因 LICENSE 問題，Imagick 改為放完整的檔案(包含 include,lib)，並修改 MAGICK_HOME 環境變數
- 請務必執行一次 auto-config.bat 升級才能確保 MAGICK_HOME 是正確的

0.3.5 2016-03-29
-----------------------

- composer 升級至最新版
- 升級 phpMyAdmin 至 4.5.5.1
- 升級 PHP70 至 7.0.4
- 升級 PHP56 至 5.6.19
- 升級 PHP55 至 5.5.33
- PHP70/56/55 都加入 extension : php-apcu
- php-xdebug 升級至 2.4.0 正式版

0.3.4 2016-02-19
------------------

- composer 升級至最新版
- 升級 PHP70 至 7.0.3
- 升級 PHP56 至 5.6.18
- 升級 PHP55 至 5.5.32
- 升級 phpmyadmin 至 4.5.4.1
- 升級 php-xdebug 至 2.4.0 RC4

0.3.3 2016-01-14
------------------

- composer 升級至最新版
- 升級 PHP70 至 7.0.2
- 升級 PHP56 至 5.6.17
- 升級 PHP55 至 5.5.31
- 升級 phpmyadmin 至 4.5.3.1
- 升級 php-imagick 至 3.4.0RC5
- php_fileinfo 預設載入
- php_intl 預設載入

0.3.2 2015-12-13
------------------

- 升級 Apache 至 2.4.18
- 升級 php-imagick 至 3.4.0rc3
- PHP 7.0 加入 php-imagick 3.4.0rc3 (必須執行一次 auto-config.bat 會自動設定)
- 升級 xdebug 至 2.4.0 RC3
- composer 更新到最新版

0.3.1 2015-12-04
------------------

- 升級 PHP56 至 5.6.16
- 升級 PHP 7.0 至正式版
- php55/php56 升級 xdebug 至 2.4.0 RC2
- php70 增加 xdebug 2.4.0 RC2



0.3.0 2015-10-21
------------------

- 增加 PHP 7.0
  - php_mysql 正式被移除了，所以不會支援 mysql function，僅能使用 mysqli or PDO
  - imagick 目前不支援 , 待官方正式編譯好後才會支援
  - xdebug 目前不支援 , 待官方正式編譯好後才會支援
- 升級 PHP55 至 5.5.30
- 升級 PHP56 至 5.6.14
- 升級 phpMyAdmin 至 4.5.0.2
- 升級 composer
- 升級 Apache 至 2.4.17

0.2.5 2015-10-01
------------------

- 修改系統變數 Path 時，會保留原本的字串

0.2.4 2015-09-30
------------------

- 修復第一次執行 auto-config.bat ，php fastcgi 設定失敗的問題

0.2.3 2015-09-28
------------------

- 加入完整 ImageMagick 檔案，可以直接執行 convert 進行轉檔
- 修復 php imagick support format no value
- 修復 session 預設儲存於 C:\Windows 的問題，現在會存於環境變數所指定的位置，如 C:\Windows\Temp


0.2.2 2015-09-27
------------------

- 增加 composer

0.2.1 2015-09-26
------------------

- auto-config.bat 會自動將 ApacheMonitor 建立 StartUp 連結於開機時啟動
- 預設載入 php_sockets.dll

0.2.0 2015-09-26
------------------

- 大幅修改目錄結構是為了將來好升級，若有安裝 0.1.0 的人請重新安裝
- auto-config.bat 現在可以自動要求 Admin 權限
- 實作切換 PHP 5.6 及 5.5 機制，當未來有 PHP 7 的 Windows 版出來時才好升級
- 增加 php 5.5.29 nts 64bit
- 增加 php_imagick 3.3.0rc2 模組

0.1.0 2015-09-25
------------------

- 增加 php 5.6.13 nts 64bit
- 增加 xdebug 2.3.3
- 增加 phpMyAdmin 4.4.15
- 增加 Apache 2.4.16 64bit
- 增加 win-bash 1.1
- 增加 mod_fcgid-2.3.9-V14