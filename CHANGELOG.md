phpdevserver Change Log
========================

0.2.6 2015-10-02
------------------------

- Upgrade PHP 5.6 To 5.6.14
- Upgrade PHP 5.5 To 5.5.30


0.2.5 2015-10-01
------------------------

- 修改系統變數 Path 時，會保留原本的字串

0.2.4 2015-09-30
------------------------

- 修復第一次執行 auto-config.bat ，php fastcgi 設定失敗的問題

0.2.3 2015-09-28
------------------------

- 加入完整 ImageMagick 檔案，可以直接執行 convert 進行轉檔
- 修復 php imagick support format no value
- 修復 session 預設儲存於 C:\Windows 的問題，現在會存於環境變數所指定的位置，如 C:\Windows\Temp


0.2.2 2015-09-27
------------------------

- 增加 composer

0.2.1 2015-09-26
-----------------------

- auto-config.bat 會自動將 ApacheMonitor 建立 StartUp 連結於開機時啟動
- 預設載入 php_sockets.dll

0.2.0 2015-09-26
-----------------------

- 大幅修改目錄結構是為了將來好升級，若有安裝 0.1.0 的人請重新安裝
- auto-config.bat 現在可以自動要求 Admin 權限
- 實作切換 PHP 5.6 及 5.5 機制，當未來有 PHP 7 的 Windows 版出來時才好升級
- 增加 php 5.5.29 nts 64bit
- 增加 php_imagick 3.3.0rc2 模組

0.1.0 2015-09-25
-----------------------

- 增加 php 5.6.13 nts 64bit
- 增加 xdebug 2.3.3
- 增加 phpMyAdmin 4.4.15
- 增加 Apache 2.4.16 64bit
- 增加 win-bash 1.1
- 增加 mod_fcgid-2.3.9-V14