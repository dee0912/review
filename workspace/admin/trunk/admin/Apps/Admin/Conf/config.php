<?php

return array(
    'VERSION' => "201411241438",
    'URL_ROUTER_ON' => true,
    'LODP_HOST' => 'ldap://172.16.10.206',
    'LODP_PORT' => '389',
    'LODP_NAME_PREFIX' => 'chunbo\\',
    'REDIS_HOST' => '172.16.10.235',
    'REDIS_PORT' => '6379',
    'SYSTEM_CACHE_TIME' => '3600',
    'DB_ADMIN' => array(
        'db_type' => 'mysql',
        'db_user' => 'root',
        'db_pwd' => '',
        'db_host' => '172.16.10.237',
        'db_port' => '3306',
        'db_name' => 'AdminDB',
        'db_charset' => 'utf8',),
    'DB_PRODUCT' => array(
        'db_type' => 'mysql',
        'db_user' => 'root',
        'db_pwd' => '',
        'db_host' => '172.16.10.237',
        'db_port' => '3306',
        'db_name' => 'ProductDB',
        'db_charset' => 'utf8',),
    'DB_PERMISSION' => array(
        'db_type' => 'mysql',
        'db_user' => 'root',
        'db_pwd' => '',
        'db_host' => '172.16.10.237',
        'db_port' => '3306',
        'db_name' => 'PermissionDB',
        'db_charset' => 'utf8',),
    'DB_LOG' => array(
        'db_type' => 'mysql',
        'db_user' => 'root',
        'db_pwd' => '',
        'db_host' => '172.16.10.237',
        'db_port' => '3306',
        'db_name' => 'LogForeDB',
        'db_charset' => 'utf8',),
    'USER_REG_SMS_TIME_LIMT' => '5', //设定用户短信失效时间（单位：分钟）
    'SSO_SITE_URL' => 'http://sso.benzhiqiang.com/',
    'MEMBER_URL'=> 'member.libj.com',
    "FDFS_TRACKER_SERVER"=>"http://dfs1.chunbo.local:22122/",
    "FDFS_STORAGE_SERVER"=>"http://dfs1.chunbo.local:23000/",
    "FDFS_DOWNLOAD_SERVER"=>"http://dfs1.chunbo.local:8080/",
    "CMS_SITE_URL"=>'http://chenkuanxin.cms.com/',
);

