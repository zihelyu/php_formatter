<?php

// +----------------------------------------------------------------------
// | Quotes [南来北往,不辜负生活,不迷失方向,朝更好的方向迈进,变成理想中的自己]
// +----------------------------------------------------------------------
// | Copyright (c) 2021 http://blog.dawnwl.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 吕梓赫 <10001@682o.com>
// +----------------------------------------------------------------------
// | Date: 2021/11/10
// +----------------------------------------------------------------------
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter;
require 'vendor/autoload.php';
error_reporting(0);
set_time_limit(0);
header('content-Type: text/html; charset=utf-8');
$basedir = __DIR__ . '/code';
echo '当前目录为：' . $basedir . '<br />';
//print_r($matchs);exit;
checkdir($basedir);
function checkdir($basedir)
{
    if ($dh = opendir($basedir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file != '.' && $file != '..') {
                if (!is_dir($basedir . '/' . $file)) {
                    echo '<pre>文件: ' . $basedir . '/' . $file . php_format($basedir . '/' . $file) . '</pre>';
                } else {
                    $dirname = $basedir . '/' . $file;
                    checkdir($dirname);
                }
            }
        }
        closedir($dh);
    }
}
function php_format($filename)
{
    if (pathinfo($filename, PATHINFO_EXTENSION) == 'php') {
        $code = file_get_contents($filename);
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        $prettyPrinter = new PrettyPrinter\Standard();
        $ast = $parser->parse($code);
        $prettyCode = $prettyPrinter->prettyPrintFile($ast);
        file_put_contents($filename, $prettyCode);
        return ' <span style="color:red">美化成功</span>';
    } else {
        return ' 无需操作';
    }
}