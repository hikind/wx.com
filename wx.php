<?php
/**
 * Created by PhpStorm.
 * User: kindness
 * Date: 2019/3/4
 * Time: 13:41
 */
include 'Wechat.php';

//实例化
$wx = new WeChat();
var_dump($wx->getAccessToken());