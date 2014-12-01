<?php

namespace Admin\Common;

use Redis;
use Admin\Common\RedisBase;

/**
 * Redis操作工具类
 */
class RedisHelper {

    private static $_instance;
    public static $_radis;

    private function __construct() {
        self::$_radis = new Redis();
        self::$_radis->connect(C("REDIS_HOST"), C("REDIS_PORT"));
    }

    public static function getInstance() {

        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    private function __clone() {
    }

}
