<?php

//需要修改php.ini来达到一些目的：
//session.auto_start = 1				--自动开始，不需要session_start()
//session.cookie_lifetime = 31536000	--cookies中的session_id一年才过期
//session.gc_maxlifetime = 1			--服务器端尽快过期，不保存了

namespace Admin\Common;

use Admin\Common\RedisHelper;

/**
 * 网站Session操作工具类
 */
class SessionHelper {

    private static $prefix = 'admin:session:';

    /**
     * 获取一个session
     * @param string 要获取的key
     * @return string 返回key对应的值
     */
    public static function get($key) {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->hGet(self::$prefix . session_id(), $key);
    }

    /**
     * 设置一个session
     * @param string 要设置的key，如果已经存在则会被更新
     * @param string 要设置的值
     * @return bool 成功为true，失败为false
     */
    public static function set($key, $value) {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->hSet(self::$prefix . session_id(), $key, $value);
    }

    /**
     * 删除一个session
     * @param string 要删除的key
     * @return bool 成功为true，失败为false
     */
    public static function del($key) {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->hDel(self::$prefix . session_id(), $key);
    }

    /**
     * 使当前用户的session过期
     * @return bool 成功为true，失败为false
     */
    public static function expire() {
        $redis_helper = RedisHelper::getInstance();
        $redis = $redis_helper::$_radis;
        return $redis->del(self::$prefix . session_id());
    }

}
