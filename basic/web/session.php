<?php
//设置session保存到memcache中
ini_set('session.save_handler','memcache');
//设置session的保存位置
ini_set('session.save_path','tcp://127.0.0.1:11211');
//开启session会话
session_start();
//向session中存储数据
$_SESSION['name'] = 'sadfas';
$_SESSION['age'] = 23;
//获取sessionz中的数据
print_r($_SESSION['name']);
echo '<pre>';
echo session_id();
?>