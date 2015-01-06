--TEST--
Test for bug #1089: Zend OPcache and Xdebug conflict with exceptions
--SKIPIF--
<?php if (!extension_loaded('Zend OPcache')) { echo "skip Zend OPcache not loaded"; } ?>
--INI--
opcache.enable_cli=1
xdebug.default_enable=1
--FILE--
<?php
if(php_sapi_name()) {
        try { // 1
                try { // 2
                        throw new Exception('Raaaa');
                } catch (Exception $e) { // 2
                        echo 'hello';
                        throw $e;
                }
        } catch (Exception $e1) { // 1
                // squash
        }
}
?>
--EXPECT--
hello
