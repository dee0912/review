<?php

namespace Admin\Common;

use Admin\Common\RedisHelper;

/**
 * 网站Session操作工具类
 */
class CacheHelper {

    private static $prefix = 'sso:cache:';

    /**
     * 获取一个session
     * @param string 要获取的key
     * @return string 返回key对应的值
     */
    public static function get($key) {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->get(self::$prefix . $key);
    }

    /**
     * 设置一个session
     * @param string 要设置的key，如果已经存在则会被更新
     * @param string 要设置的值
     * @return bool 成功为true，失败为false
     */
    public static function set($key, $value, $time = 3600) {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->setex(self::$prefix . $key, $time, $value);
    }

    /**
     * 删除一个session
     * @param string 要删除的key
     * @return bool 成功为true，失败为false
     */
    public static function del($key) {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->delete(self::$prefix . $key);
    }

}
