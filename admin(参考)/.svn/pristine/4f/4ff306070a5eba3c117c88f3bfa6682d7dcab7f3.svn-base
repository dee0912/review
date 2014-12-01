<?php

namespace Think;
/**
 *redis 类
 */
class Myredis extends \Redis {

    private $enableError = true;
    private $loger;

    public function __destruct() {
        if ($this->loger)
            $this->loger->logfile_close();
    }

    public function __construct() {
        parent::__construct();
        if ($this->enableError) {//如果存在错误放入文档中
            $this->loger = new redisLoger();
            $this->loger->logPath=dirname(__FILE__)."/logs/";
            $this->loger->logfile_init();
        }
    }

    public function connect($host, $port = 6379, $timeout = 0.0) {
        try {
            return parent::connect($host, $port, $timeout);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    public function logErr($str, $e) {
        $this->loger->logErr($str, $e);
    }

    /**
     * 获取key值
     * demo string get('key') 获取单个key值
     * demo string keys get(array('key1','key2')); 获取多个key值
     * demo arr get('arrkey',true); 获取一个数组类型的值，不能一次获取多个键值
     * @param string|array $key 缓存KEY,支持一次取多个 $key = array('key1','key2')
     * @param bool $isArr 是否取数组类型，默认取字符串类型
     * @return string|boolean 键值内容  失败返回 false, 成功返回字符串或数组
     */
    public function get($key, $isArr = false) {
        try {
            if ($isArr)
                return parent::hgetall($key);
            elseif (is_array($key))
                return parent::mget($key);
            else
                return parent::get($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 设置字符串类型的值
     * demo array set('s', array('name' => '测试','age'=>'12')); 向数组s下添加或者是覆盖下标name和age
     * demo string set('s', '测试'); 永久存储s字符串
     * demo string set('s', '测试',10); 存储10秒过期的s字符串
     * @param string $key 键值
     * @param string|array $value 键值内容
     * @param string $timeout 过期时间
     * @return boolean 
     */
  /*  public function set($key, $value, $timeout = 0.0) {
        try {
            if (is_array($value))
                return parent::hmset($key, $value);
            if ($timeout > 0)
                return parent::setex($key, $timeout, $value);
            else
                return parent::set($key, $value, $timeout);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }*/

    /* ===================字符串操作========================== */

    /**
     * 返回原来key中的值，并将value写入key
     * @param string $key 键值
     * @param string $value 键值内容
     * @return string 原有键值内容 
     */
    public function getSet($key, $value) {
        try {
            return parent::getSet($key, $value);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 名称为key的string的值在后面加上value
     * @param string $key 键值
     * @param string $exvalue 追加字符
     * @return int 追加后字符串的长度
     */
    public function append($key, $exvalue) {
        try {
            return parent::append($key, $exvalue);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 写入时，判断是否存在,如果 key 不存时就设置，存在时设置失败
     * @param string $key 键值
     * @param string $value 键值内容
     * @return boolean 
     */
    public function setNx($key, $value) {
        try {
            return parent::setnx($key, $value);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 查询键的过期时间
     * @param string $key 键值
     * @return int >0|-1 还有多长时间过期   
     */
    public function ttl($key) {
        try {
            return parent::ttl($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /* =========================hush操作================================== */

    /**
     * 按照数组下标获取该下标下的值
     * demo hGet('key','name');
     * @param string $key 键值
     * @param array $hashKey 数组下标
     * @return string|bool 
     */
    public function hGet($key, $hashKey) {
        try {
            return parent::hGet($key, $hashKey);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 删除数组下的一个下标值
     * demo hDel('key','name');
     * @param string $key 键值
     * @param string $hashKey 数组下标
     * @return boolean 
     */
    public function hDel($key, $hashKey) {
        try {
            return parent::hDel($key, $hashKey);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 判断数组下边有没有下标
     * demo hExists('key','name');
     * @param string $key  键值
     * @param string $hashKey 数组下标
     * @return boolean 
     */
    public function hExists($key, $hashKey) {
        try {
            return parent::hexists($key, $hashKey);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /* =======================List操作=============================== */

    /**
     * 向list左侧添加一条记录
     * @param string $key 键值
     * @param string $value 键值内容
     * @return boolean
     */
    public function lpush($key, $value) {
        try {
            return parent::lpush($key, $value);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 向list右侧添加一条记录
     * @param string $key 键值
     * @param string $value 键值内容
     * @return boolean
     */
    public function rpush($key, $value) {
        try {
            return parent::rpush($key, $value);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 获取list的最左侧一条记录
     * @param string $key 键值
     * @return string 键值内容
     */
    public function lpop($key) {
        try {
            return parent::lpop($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 获取list的最右侧一条记录
     * @param string $key 键值
     * @return string 键值内容
     */
    public function rpop($key) {
        try {
            return parent::rpop($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 获取list的条数
     * @param string $key 键值
     * @return int
     */
    public function llen($key) {
        try {
            return parent::llen($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 获取list的记录
     * @param string $key 键值
     * @param int $start 开始位置
     * @param int $end 长度
     * @return list
     */
    public function lRange($key, $start = 0, $end = '-1') {
        try {
            return parent::lRange($key, $start, $end);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 修改队列指定位置的值
     * @param string $key 队列名
     * @param int $index 要修改的键值下标
     * @param string $value 要修改的内容
     * @return boolean
     */
    public function lset($key, $index, $value) {
        try {
            return parent::lset($key, $index, $value);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /* ============================通用操作=============================== */

    /**
     * 获取满足给定通配符的所有key
     * demo redis::keys('nam*');
     * @param string $subkey
     * @return array 
     */
    public function keys($subkey) {
        try {
            return parent::keys($subkey);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 判断key值是否存在
     * @param string $key 键值
     * @return boolean 
     */
    public function exists($key) {
        try {
            return parent::exists($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 删除key值
     * @param string $key 键值
     * @return boolean 
     */
    public function delete($key) {
        try {
            return parent::delete($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

    /**
     * 查看键值类型
     * @param string $key 键值
     * @return string 键值类型 string|list|hush
     */
    public function type($key) {
        try {
            return parent::type($key);
        }
        catch (RedisException $e) {
            $this->logErr(__FUNCTION__ . " Error!: " . $e->getMessage() . "\n", $e);
            return false;
        }
    }

}

class redisLoger {

    private $LOGFILE = "";
    var $FILE_HANDLER;
    public $logPath;
    static function forceDirectory($dir) { // force directory structure
        return is_dir($dir) or (self::forceDirectory(dirname($dir)) and mkdir($dir, 0777));
    }

    function logfile_init() {
        if (empty($this->LOGFILE)) {
            $filename = $this->logPath. 'redis' . date('Ymd') . '.log';
            $this->LOGFILE = $filename;
        }
        else {
            $filename = $this->LOGFILE;
        }
        self::forceDirectory($this->logPath);
        $this->FILE_HANDLER = fopen($filename, 'a');
    }

    public function logErr($str, $e) {
        $file_size = filesize($this->LOGFILE);
        if ($file_size > 1000000000)
            return;
        $err = "\n" . date(("Ymd H:i:s")) . "-->" . $str . ":::" . print_r($e, true) . "<--";
        substr($err, 0, 15000);
        if ($this->FILE_HANDLER) {
            fwrite($this->FILE_HANDLER, $err); //暂时用写入log，空间不够
        }
    }

    public function logfile_close() {
        if ($this->FILE_HANDLER) {
            fclose($this->FILE_HANDLER);
        }
    }

}

?>
