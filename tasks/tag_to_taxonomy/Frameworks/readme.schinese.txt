
使用方法：
1 解压缩后检查/Frameworks/art/ 等目录下的 xoops_version.php内的版本定义，确认该版本比你当前所用版本新

2 将/Frameworks/目录上传到你的XOOPS根目录下，效果为
  XOOPS/Frameworks/art
  XOOPS/Frameworks/captcha
  XOOPS/Frameworks/fpdf
  XOOPS/Frameworks/PEAR
  XOOPS/Frameworks/textsanitizer
  XOOPS/Frameworks/transfer
  XOOPS/Frameworks/compat
  XOOPS/Frameworks/xoops22 (for compat)

3 检查文件名，确认正确使用了大小写，比如"Frameworks"不是"frameworks"	

4 设定相关参数
4.1 ./fpdf/language/: make your local langauge file based on english.php, you could check schinese.php as example, or inline comments in english.php
4.2 ./textsanitizer/config.php: check inline comments
4.3 ./transfer/:
4.3.1 ./transfer/language/: make your local langauge file based on english.php
4.3.2 ./transfer/modules/: for developers only, add transfer handler for your module, or store the file as: XOOPS/modules/mymodule/include/plugin.transfer.php
4.3.3 ./transfer/plugin/: add items available for the transfer
4.3.4 ./transfer/plugin/myplugin/config: configurations for a plugin
4.3.5 ./transfer/plugin/myplugin/language/: make your local langauge file based on english.php
4.3.6 ./transfer/bar.transfer.php: set "$limit" for number of plugins that will be displayed on a front page;
4.4 ./compat/language/: make your local langauge files based on /english/
4.5 ./captcha/:
4.5.1 ./captcha/language/: make your local langauge file based on english.php
4.5.2 ./captcha/config.php: set configs

5 XOOPS 2.2* 用户需要把
/Frameworks/compat/language/english/local.php
/Frameworks/compat/language/english/local.class.php
/Frameworks/compat/language/schinese/local.php
(或/Frameworks/compat/language/schinese_utf8/local.php)
分别拷贝到XOOPS/language/相应目录下